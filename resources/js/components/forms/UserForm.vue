<script>
    import usersAPI from "../../api/users"
    export default {
        name: "UserForm",
        props: {
            userFormTriggered: Boolean,
            user: Object
        },
        computed: {
            isNew() {
                return this.user && !this.user.id
            },
            isLoading() {
                return this.$store.getters.isLoading
            },
            status() {
                return this.$store.getters.status
            }
        },
        created() {
            if (!this.isNew) {
                this.fields = {
                    email: this.user.email,
                    name: this.user.name,
                    password: this.user.password
                }
            }
        },
        data() {
            return {
                fields: {
                    email: null,
                    name: null,
                    password: null
                },
                passwordChecked: false
            }
        },
        methods: {
            allowPasswordModification() {
                if (!this.passwordChecked) {
                    this.fields.password = null
                }
            },
            closeUserForm() {
                this.$emit('closeUserForm')
            },
            dismissAlert() {
                this.$store.dispatch('loadStatus', null);
            },
            emitEvents() {
                this.$store.dispatch('loadUsers')
                    .then(() => {
                        this.$store.dispatch('loadStatus', {
                            type: "success",
                            message: this.fields.name + " successfully saved"
                        });
                        this.closeUserForm();
                        this.$store.dispatch('loadIsLoading', false);
                    })
            },
            updateUser() {
                this.$store.dispatch('loadIsLoading', true);
                if (!this.isNew) {
                    if (this.passwordChecked && !this.fields.password) {
                        this.$store.dispatch('loadIsLoading', false);
                        this.$store.dispatch('loadStatus', {
                            type: "error",
                            message: "Please provide a password or unselected option"
                        })
                    } else {
                        usersAPI.updateUser(this.user.id, this.fields)
                            .then(() => this.emitEvents())
                    }
                } else {
                    if (this.fields.name && this.fields.email && this.fields.password) {
                        usersAPI.createUser(this.fields).then(() => this.emitEvents())
                    } else {
                        this.$store.dispatch('loadIsLoading', false);
                        this.$store.dispatch('loadStatus', {
                            status: "error",
                            message: "Missing fields"
                        })
                    }
                }
            }
        }
    }
</script>

<style scoped>

</style>

<template>
    <v-dialog v-model="userFormTriggered" persistent max-width="600px">
        <v-card>
            <v-card-title>
                <span class="headline" v-if="!isNew">Edit {{ this.user.name }}</span>
                <span class="headline" v-if="isNew">Create user</span>
            </v-card-title>
            <v-container v-if="status && status.type === 'error'">
                <v-alert v-model="status && status.type === 'error'" :dismissible="true" :type="status.type"
                         transition="scale-transition" @click="dismissAlert">
                    {{ status.message }}
                </v-alert>
            </v-container>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex xs12>
                            <v-text-field label="Name*" required v-model="fields.name"></v-text-field>
                        </v-flex>
                        <v-flex xs12 v-if="isNew">
                            <v-text-field label="Email*" required v-model="fields.email"></v-text-field>
                        </v-flex>
                        <v-flex xs12 v-if="!isNew">
                            <v-checkbox @onchange="allowPasswordModification" label="Change password"
                                        v-model="passwordChecked"></v-checkbox>
                        </v-flex>
                        <v-flex xs12>
                            <v-text-field :disabled="!isNew && !passwordChecked" v-model="fields.password"
                                          label="Password*" type="password" :required="isNew || passwordChecked">
                            </v-text-field>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="closeUserForm">Close</v-btn>
                <v-btn :loading="isLoading" :disabled="isLoading" color="blue darken-1"
                       flat @click="updateUser">Save</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
