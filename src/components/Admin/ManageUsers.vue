<script setup>

    import { onMounted } from "vue";
    import {ref, reactive} from 'vue'

    const users = ref(null)
    const deleteUserDialog = ref(false)
    const editUserDialog = ref(false)
    const loading = ref(false)
    const showPassword = ref(false)
    const snackbarText =ref('')
    const snackbar = ref(false)

    const updateUserForm = reactive({
        id: null,
        first_name: null,
        last_name: null,
        department: null,
        email: null,
        password: null,
        role: null
    })

    const deleteUserForm = reactive({
        id: null,
        first_name: null,
        last_name: null
    })

    function showEditUserDialog(selectedUser) {
        updateUserForm.id = selectedUser.id
        updateUserForm.first_name = selectedUser.first_name
        updateUserForm.last_name = selectedUser.last_name
        updateUserForm.department = selectedUser.department
        updateUserForm.email = selectedUser.email
        updateUserForm.role = selectedUser.role
        updateUserForm.password = selectedUser.password
        editUserDialog.value = true
    }

    function showDeleteUserDialog(selectedUser) {
        deleteUserForm.id = selectedUser.id
        deleteUserForm.first_name = selectedUser.first_name
        deleteUserForm.last_name = selectedUser.last_name
        deleteUserDialog.value = true
    }

    onMounted(() => {
        getAllUsers()
    })

    function getAllUsers() {
        let data = new FormData();
        data.append('method','getAllStudents')
        fetch('http://localhost/account-management-system-master/backend/index.php',
            {
                method:'POST',
                body:data
            }
        )
        .then(res =>{
            return res.text();
        })
        .then(data =>{
            users.value = JSON.parse(data);
        })
    }

    function updateUser() {
        loading.value = true
        let data = new FormData();
        data.append('method', 'updateUser');
        data.append('id', updateUserForm.id)
        data.append('first_name', updateUserForm.first_name)
        data.append('last_name', updateUserForm.last_name)
        data.append('email', updateUserForm.email)
        data.append('department', updateUserForm.department)
        data.append('role', updateUserForm.role)
        data.append('password', updateUserForm.password)

        fetch(`http://localhost/account-management-system-master/backend/index.php`,
        {
            method: 'POST',
            body: data,
        })
        .then(() => {
            getAllUsers()
            editUserDialog.value = false
            loading.value = false
            snackbarText.value = "User updated successfully"
            snackbar.value = true
        })
        .catch((error) => {
            editUserDialog.value = false
            loading.value = false
        })
    }

    function deleteUser() {
        loading.value = true
        let data = new FormData();
        data.append('method', 'deleteUser');
        data.append('id', deleteUserForm.id)

        fetch(`http://localhost/account-management-system-master/backend/index.php`,
        {
            method: 'POST',
            body: data,
        })
        .then(() => {
            getAllUsers()
            deleteUserDialog.value = false
            loading.value = false
            snackbarText.value = "User deleted successfully"
            snackbar.value = true
        })
        .catch((error) => {
            deleteUserDialog.value = false
            loading.value = false
        })
    }

</script>
<template>
    <p class="text-h3">Manage users</p>
    <v-table>
        <thead>
            <tr>
                <th class="text-left"> Id </th>
                <th class="text-left"> First name </th>
                <th class="text-left"> Last name </th>
                <th class="text-left"> Email </th>
                <th class="text-left"> Department </th>
                <th class="text-left"> Role </th>
                <th class="text-left"> Actions </th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="user in users" :key="user.id">
                <td>{{ user.id }}</td>
                <td>{{ user.first_name }}</td>
                <td>{{ user.last_name }}</td>
                <td>{{ user.email }}</td>
                <td>{{ user.department }}</td>
                <td>{{ user.role }}</td>
                <td>
                    <v-btn class="me-3" @click="showEditUserDialog(user)" color="blue" prepend-icon="mdi-square-edit-outline">Edit</v-btn>
                    <v-btn color="red" @click="showDeleteUserDialog(user)" prepend-icon="mdi-delete-empty-outline">Delete</v-btn>
                </td>
            </tr>
        </tbody>
    </v-table>



    <v-dialog v-model="editUserDialog" width="80%">
        <v-card title="Edit user">
            <v-card-text>
                <v-row>
                    <v-col cols="6">
                        <v-text-field label="First name" v-model="updateUserForm.first_name" name="first_name"></v-text-field>
                    </v-col>
                    <v-col cols="6">
                        <v-text-field label="Last name" v-model="updateUserForm.last_name" name="last_name"></v-text-field>
                    </v-col>
                </v-row>
                <v-text-field label="Email" v-model="updateUserForm.email" name="email"></v-text-field>
         
                <v-row>
                    <v-col cols="6">
                        <v-select :items="['BSIT', 'BEED', 'BSED', 'BSHM']" v-model="updateUserForm.department" name="department" label="Department"></v-select>
                    </v-col>
                    <v-col cols="6">
                        <v-select :items="['Student', 'Admin']" v-model="updateUserForm.role" name="role" label="Role"></v-select>
                    </v-col>
                </v-row>

                <v-text-field label="Password" v-model="updateUserForm.password" :type="showPassword ? '' : 'password'" name="password">
                    <template v-slot:append-inner>
                        <v-btn size="small" variant="text" :icon="showPassword ? 'mdi-eye-outline' : 'mdi-eye-off-outline'" @click="showPassword = !showPassword"></v-btn>
                    </template>
                </v-text-field>
            </v-card-text>
            <v-card-actions>
                <v-spacer/>
                <v-btn color="grey" @click="editUserDialog = false">Cancel</v-btn>
                <v-btn color="blue" @click="updateUser()" :loading="loading">Update</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <v-dialog v-model="deleteUserDialog" width="auto">
        <v-card title="Delete user">
            <v-card-text>
                Are you sure you want to delete <strong>{{ deleteUserForm.first_name }} {{ deleteUserForm.last_name }}</strong>?
            </v-card-text>
            <v-card-actions>
                <v-spacer/>
                <v-btn color="grey" @click="deleteUserDialog = false">Cancel</v-btn>
                <v-btn color="red" @click="deleteUser()">Delete</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

    <v-snackbar v-model="snackbar" color="green" timeout="2000" location="bottom left">
      {{ snackbarText }}
    </v-snackbar>

</template>