import axios from 'axios'

export default {

    list() {
        const path = '/api/users';

        return axios.get(path)
    },

    createUser(profile) {
        const path = '/api/users';

        return axios.post(path, { profile })
    },

    updateUser(userId, profile) {
        const path = '/api/users/' + userId;

        return axios.put(path, { profile })
    },

    updatePermission(userId, permission) {
        const path = '/api/users/' + userId + '/permission';

        return axios.put(path, { permission })
    },

    deleteUser(userId) {
        const path = '/api/users/' + userId;

        return axios.delete(path)
    }
}
