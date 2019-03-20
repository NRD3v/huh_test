<script>
    import usersAPI from "../../api/users"
    export default {
        name: "PermissionForm",
        props: {
            permissionFormTriggered: Boolean,
            user: Object
        },
        computed: {
            isLoading() {
                return this.$store.getters.isLoading
            }
        },
        created() {
            if (this.user) {
                this.fields = {
                    has_administration_rights: this.user.permission.has_administration_rights,
                    has_onboarding_rights: this.user.permission.has_onboarding_rights,
                    has_view_user_rights: this.user.permission.has_view_user_rights,
                }
            }
        },
        data() {
            return {
                fields: {
                    has_administration_rights: false,
                    has_onboarding_rights: false,
                    has_view_user_rights: false
                }
            }
        },
        methods: {
            closePermissionForm() {
                this.$emit('closePermissionForm')
            },
            emitEvents() {
                this.$store.dispatch('loadStatus', {
                    type: "success",
                    message: this.user.name + " permission successfully saved"
                });
                this.$store.dispatch('loadIsLoading', false);
                this.closePermissionForm()
            },
            updatePermission() {
                this.$store.dispatch('loadIsLoading', true);
                usersAPI.updatePermission(this.user.id, this.fields)
                    .then(() => {
                        this.$store.dispatch('loadUsers').then(() => this.emitEvents())
                    })
            }
        }
    }
</script>

<style scoped>

</style>

<template>
    <v-dialog v-model="permissionFormTriggered" persistent max-width="600px">
        <v-card>
            <v-card-title>
                <span class="headline">Edit permission of {{ this.user.name }}</span>
            </v-card-title>
            <v-card-text>
                <v-container grid-list-md>
                    <v-layout wrap>
                        <v-flex>
                            <v-checkbox label="Administration" v-model="fields.has_administration_rights"></v-checkbox>
                        </v-flex>
                        <v-flex xs12>
                            <v-checkbox label="Onboarding" v-model="fields.has_onboarding_rights"></v-checkbox>
                        </v-flex>
                        <v-flex xs12>
                            <v-checkbox label="Users" v-model="fields.has_view_user_rights"></v-checkbox>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card-text>
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="blue darken-1" flat @click="closePermissionForm">Close</v-btn>
                <v-btn :loading="isLoading" :disabled="isLoading" color="blue darken-1"
                       flat @click="updatePermission">Save</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>
