<script setup>

    import {reactive, ref} from 'vue'

    const loading = ref(false)
    const auth = ref(null)
    auth.value = JSON.parse(localStorage.getItem('auth'))
    const editable = ref(false)
    const showPassword = ref(false)
    const snackbar = ref(false)
    const updateUserForm = reactive({
        id: auth.value.id,
        first_name: auth.value.first_name,
        last_name: auth.value.last_name,
        department: auth.value.department,
        email: auth.value.email,
        role: auth.value.role,
        password: auth.value.password,    
    })
    
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
        .then(res =>{
            return res.text();
        })
        .then(data =>{
            auth.value = JSON.parse(data)
            localStorage.setItem('auth', JSON.stringify(auth.value[0]))
            loading.value = false
            editable.value = false
            snackbar.value = true
        })
        .catch((error) => {
            loading.value = false
        })
    }
</script>
<template>
    
    <v-container>
        <v-row>
            <v-col cols="12">
                 
            </v-col>
        </v-row>
        <v-row>
            <v-col cols="12" class="justify-center d-flex">
                <v-card :loading="loading"  width="50%" :elevation="editable ? '10' : '2'">
                    <v-card-title>
                       {{  editable ? 'Edit account' : 'Account' }}
                    <v-btn :prepend-icon="editable ? 'mdi-close' : 'mdi-square-edit-outline'" @click="editable = !editable" variant="text" :color="editable ? 'red' : 'blue'">Edit</v-btn> 
                    </v-card-title>
                <v-divider/>
                <v-card-text>
                    <v-row>
                        <v-col cols="6">
                            <v-text-field label="First name" :readonly="!editable" :variant="editable ? 'underlined' : 'plain'" v-model="updateUserForm.first_name" name="first_name"></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <v-text-field label="Last name" :readonly="!editable" v-model="updateUserForm.last_name" :variant="editable ? 'underlined' : 'plain'" name="last_name"></v-text-field>
                        </v-col>
                    </v-row>
                    <v-text-field label="Email" :readonly="!editable" v-model="updateUserForm.email" :variant="editable ? 'underlined' : 'plain'" name="email"></v-text-field>
                    <v-select active :readonly="!editable" :items="['BSIT', 'BEED', 'BSED', 'BSHM']" :variant="editable ? 'underlined' : 'plain'" v-model="updateUserForm.department" name="department" label="Department"></v-select>
                    <v-text-field :readonly="!editable" :variant="editable ? 'underlined' : 'plain'" label="Password" v-model="updateUserForm.password" :type="showPassword ? '' : 'password'" name="password">
                        <template v-slot:append-inner>
                            <v-btn size="small" variant="text" :icon="showPassword ? 'mdi-eye-outline' : 'mdi-eye-off-outline'" @click="showPassword = !showPassword"></v-btn>
                        </template>
                    </v-text-field>
                </v-card-text>
                <v-card-actions v-if="editable">
                    <v-spacer/>
                    <v-btn color="grey" @click="editUserDialog = false">Cancel</v-btn>
                    <v-btn color="blue" @click="updateUser()" :loading="loading">Update</v-btn>
                </v-card-actions>
            </v-card>
            </v-col>
        </v-row>
    </v-container>

    <v-snackbar v-model="snackbar" color="green" timeout="2000" location="bottom left">
        Account updated successfully.
    </v-snackbar>

</template>

<style>

</style>