<template>
    <v-layout>
        <v-app-bar color="teal-darken-4" image="https://picsum.photos/1920/1080?random">
            <template v-slot:image>
                <v-img gradient="to top right, rgba(19,84,122,.8), rgba(128,208,199,.8)"></v-img>
            </template>
            <v-app-bar-title>Events and Account Management</v-app-bar-title>
            <v-spacer></v-spacer>
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
