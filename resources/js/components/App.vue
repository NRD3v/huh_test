<script xmlns:v-slot="http://www.w3.org/1999/XSL/Transform">
    import usersAPI from "../api/users"
    import PermissionForm from "./forms/PermissionForm"
    import UserForm from "./forms/UserForm"
    export default {
        components: {PermissionForm, UserForm},
        created() {
            this.$store.dispatch('loadUsers')
        },
        computed: {
            users() {
                return this.$store.getters.users
            },
            isLoading() {
                return this.$store.getters.isLoading
            },
            status() {
                return this.$store.getters.status
            }
        },
        data() {
            return {
                filter: null,
                headers: [
                    { text: 'ID', value: 'id' },
                    { text: 'Name', value: 'name' },
                    { text: 'Email', value: 'email' },
                    { text: 'Actions', value: '' }
                ],
                isDeletionTriggered: false,
                isPermissionFormTriggered: false,
                isUserFormTriggered: false,
                pagination: {
                    rowsPerPage: 10,
                    sortBy: 'id'
                },
                permissionFields: {},
                selected: [],
                user: null
            }
        },
        methods: {
            closeDeletion() {
                this.user = null;
                this.isDeletionTriggered = false
            },
            closePermissionForm() {
                this.user = null;
                this.isPermissionFormTriggered = false
            },
            closeUserForm() {
                this.user = null;
                this.isUserFormTriggered = false
            },
            deleteUser() {
                this.$store.dispatch('loadIsLoading', true);
                usersAPI.deleteUser(this.user.id).then(() => this.emitEvents())
            },
            dismissAlert() {
                this.$store.dispatch('loadStatus', null);
            },
            emitEvents() {
                this.$store.dispatch('loadUsers')
                    .then(() => {
                        this.$store.dispatch('loadStatus', {
                            type: "success",
                            message: this.user.name + " successfully deleted"
                        });
                        this.closeDeletion();
                        this.$store.dispatch('loadIsLoading', false);
                    })
            },
            triggerDeletion(user) {
                this.user = user;
                this.isDeletionTriggered = true
            },
            triggerPermissionForm(user) {
                this.user = user;
                this.isPermissionFormTriggered = true
            },
            triggerUserForm(user) {
                this.user = user;
                this.isUserFormTriggered = true
            }
        }
    }
</script>

<style scoped>
    .usersHeader {
        background-color: #ebebeb;
        height: 75px;
    }
</style>

<template>
    <v-app>
        <v-content>
            <v-container>
                <v-layout align-center justify-space-between row class="usersHeader">
                    <v-flex>
                        <h3 class="pl-3">Admin Users</h3>
                    </v-flex>
                    <v-flex xs1>
                        <v-icon @click="triggerUserForm({})" class="pl-5">add</v-icon>
                    </v-flex>
                </v-layout>

                <v-form>
                    <v-layout>
                        <v-flex xs12 md12>
                            <v-text-field v-model="filter" label="Search" prepend-inner-icon="search"></v-text-field>
                        </v-flex>
                    </v-layout>
                </v-form>

                <v-alert v-if="status && status.type === 'success'" v-model="status" :dismissible="true" :type="status.type"
                         transition="scale-transition" @click="dismissAlert">
                    {{ status.message }}
                </v-alert>

                <v-data-table v-if="!isLoading" :headers="headers" :items="users"
                              :search="filter" :pagination.sync="pagination"
                              class="elevation-1">
                    <template v-slot:items="users">
                        <td>{{ users.item.id }}</td>
                        <td>{{ users.item.name }}</td>
                        <td>{{ users.item.email }}</td>
                        <td>
                            <v-icon @click="triggerPermissionForm(users.item)">menu</v-icon>
                            <v-icon @click="triggerUserForm(users.item)">edit</v-icon>
                            <v-icon @click="triggerDeletion(users.item)">clear</v-icon>
                        </td>
                    </template>
                </v-data-table>
            </v-container>
        </v-content>

        <v-dialog v-model="isDeletionTriggered" persistent max-width="600px">
            <v-card v-if="user">
                <v-card-title>
                    <span class="headline">Remove {{ this.user.name }} from admin users ?</span>
                </v-card-title>
                <v-card-text>
                    <v-container grid-list-md>
                        <v-layout wrap>
                            Are you sure you want to remove {{ this.user.name }} from admin users ?
                        </v-layout>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" flat @click="closeDeletion">Close</v-btn>
                    <v-btn :loading="isLoading" :disabled="isLoading" color="blue darken-1"
                           flat @click="deleteUser">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <PermissionForm v-if="user && user.id" v-bind:user="user" @closePermissionForm="closePermissionForm"
                        :permissionFormTriggered="isPermissionFormTriggered" />
        <UserForm v-if="user" v-bind:user="user" @closeUserForm="closeUserForm"
                  :userFormTriggered="isUserFormTriggered" />
    </v-app>
</template>
