<script setup>

    import {reactive, ref} from 'vue'
    import { useRouter } from 'vue-router';
    const loading = ref(false)
    const student = ref(null)
    const router = useRouter()
    const showPassword = ref(false)
    const error = ref(false)
    const invalidLoginError = ref('')

    const user = reactive({
        email: null,
        password: null,
    })

    function signin() {
        loading.value = true
        let data = new FormData();
        data.append('method', 'signin');
        data.append('email', user.email)
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
            if(JSON.parse(data).length !== 0) {
                localStorage.setItem('auth', JSON.stringify(student.value[0]))
                console.log(student.value[0].role)
                if(student.value[0].role == "Admin") {
                    router.push('/admin/dashboard')
                }
                else {
                    router.push('/')
                }
            }
            else {
                invalidLoginError.value = "Invalid credentials"
                error.value = true
            }
            loading.value = false
        })
        .catch((error) => {
            loading.value = false
            error.value = true
        })
    }

    const email_rule = [
        value => {
            if (/^[a-z.-]+@[a-z.-]+\.[a-z]+$/i.test(value)) return true
            return 'Must be a valid e-mail.'
        }
    ]

    const password_rule = [
        value => {
            if (value) return true
            return 'Password field is required.'
        }
    ]

</script>

<template>
    <v-container>
        <p>Admin account</p>
        <p>email: admin@email.com</p>
        <p>pass: asdasd</p>
        <v-form fast-fail @submit.prevent class="justify-center d-flex">
            <v-card title="Sign in" width="69%" class="my-6">
                <v-card-item>
                    <v-text-field :rules="email_rule" :error-messages="invalidLoginError" label="Email" v-model="user.email"></v-text-field>
                    <v-text-field :rules="password_rule" label="Password" v-model="user.password" :type="showPassword ? 'text' : 'password'">
                    
                        <template v-slot:append-inner>
                            <v-btn v-if="user.password" :icon="showPassword ? 'mdi-eye-outline' : 'mdi-eye-off-outline'"  @click="showPassword = !showPassword" variant="text" size="small"></v-btn>
                        </template>

                    </v-text-field>
                </v-card-item>
                <v-card-actions>
                    <v-btn @click="signin" type="submit" :loading="loading">Sign in</v-btn>
                </v-card-actions>
            </v-card>
        </v-form>
    </v-container>

</template>
<style>
p{
    text-align: center;
   
}
</style>