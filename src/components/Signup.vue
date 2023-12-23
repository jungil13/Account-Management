<script setup>

    import {reactive} from 'vue'
    import {ref} from 'vue'
    import {useRouter} from 'vue-router'

    const router = useRouter()
    const student = ref(null)
    const signUpBtnLoading = ref(false)
    const showPassword = ref(false)

    const user = reactive({
        first_name: null,
        last_name: null,
        department: null,
        email: null,
        password: null,
    })

    const first_name_rule = [
        value => {
            if(value?.length > 2) return true
            return 'First name must be at least 3 characters.'
        }
    ]

    const last_name_rule = [
        value => {
            if(value?.length > 2) return true
            return 'Last name must be at least 3 characters.'
        }
    ]

    const email_rule = [
        value => {
            if (/^[a-z.-]+@[a-z.-]+\.[a-z]+$/i.test(value)) return true
            return 'Must be a valid e-mail.'
        }
    ]

    const department_rule = [
        value => {
            if (value) return true
            return 'Department field is required.'
        }
    ]

    const password_rule = [
        value => {
            if(value?.length > 2) return true
            return 'Password must be at least 3 characters.'
        }
    ]

    function signup() {

        if(user.first_name != null && user.last_name != null && user.department != null && user.email != null && user.password != null) {
            signUpBtnLoading.value = true
            let data = new FormData();
            data.append('method', 'signup');
            data.append('first_name', user.first_name)
            data.append('last_name', user.last_name)
            data.append('email', user.email)
            data.append('department', user.department)
            data.append('password', user.password)

            fetch(`http://localhost/account-management-system-master/backend/index.php`,
            {
                method: 'POST',
                body: data,
            })
            .then((response) => {
                return response.text()
            })
            .then((data) => {
                student.value = JSON.parse(data)
                localStorage.setItem('auth', JSON.stringify(student.value[0]))
                signUpBtnLoading.value = false
                router.push('/')
            })
            .catch((error) => {
                signUpBtnLoading.value = false
            })
        }
    }

    

</script>

<template>
    
    <v-container class="justify-center d-flex">
        <v-card title="Sign up" width="69%" class="my-6">
            <v-form fast-fail @submit.prevent>
                <v-card-item>
                    <v-row>
                        <v-col cols="6">
                            <v-text-field label="First name" :rules="first_name_rule" v-model="user.first_name" name="first_name"></v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <v-text-field label="Last name" :rules="last_name_rule" v-model="user.last_name" name="last_name"></v-text-field>
                        </v-col>
                    </v-row>
                    <v-text-field label="Email" :rules="email_rule" v-model="user.email" name="email"></v-text-field>
                    <v-select :rules="department_rule" :items="['BSIT', 'BEED', 'BSED', 'BSHM']" v-model="user.department" name="department" label="Department"></v-select>
                    <v-text-field :rules="password_rule" label="Password" v-model="user.password" name="password" :type="showPassword ? 'text' : 'password'">
                    
                        <template v-slot:append-inner>
                            <v-btn v-if="user.password" :icon="showPassword ? 'mdi-eye-off-outline' : 'mdi-eye-outline'" variant="text" size="small" @click="showPassword = !showPassword"></v-btn>
                        </template>

                    </v-text-field>
                </v-card-item>
                <v-card-actions>
                    <v-btn type="submit" @click="signup" :loading="signUpBtnLoading">Sign up</v-btn>
                </v-card-actions>
            </v-form>
        </v-card>   
    </v-container>

</template>