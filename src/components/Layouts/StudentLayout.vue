<script setup>

    import {ref} from 'vue'
    const auth = ref(null)
    auth.value = JSON.parse(localStorage.getItem('auth'))

    function logout() {
        localStorage.removeItem('auth')
        auth.value = null
    }

</script>
<template>
    <v-layout>
        <v-app-bar color="teal-darken-4" image="https://picsum.photos/1920/1080?random">
            <template v-slot:image>
                <v-img gradient="to top right, rgba(19,84,122,.8), rgba(128,208,199,.8)"></v-img>
            </template>
            <v-app-bar-title>Event and Account Management</v-app-bar-title>
            <v-spacer></v-spacer>
            <div v-if="auth">
                <router-link to="/">
                    <v-btn color="white">
                        Events
                    </v-btn>
                </router-link>
                <router-link to="/account">
                    <v-btn color="white">
                        Account
                    </v-btn>
                </router-link>
                <router-link to="/sign-in">
                    <v-btn color="red" @click="logout">
                        Logout
                    </v-btn>
                </router-link>
            </div>
            <div v-else>
                <router-link to="/sign-in">
                    <v-btn color="white">
                        Sign in
                    </v-btn>
                </router-link>
                <router-link to="/sign-up">
                    <v-btn color="white">
                        Sign up
                    </v-btn>
                </router-link>
            </div>
        </v-app-bar>

        <v-main class="bg-grey-darken-3">
            <v-container>
                <slot/>
            </v-container>
        </v-main>
    </v-layout>
</template>

<style scoped>
    .link {
        text-decoration: none;
    }
</style>
