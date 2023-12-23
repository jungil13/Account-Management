<script setup>

    import {ref, reactive} from 'vue'
    import { useRouter } from 'vue-router';
    const createAccouncementDialog = ref(false)
    const loading = ref(false)
    const router = useRouter()
    const announcementForm = reactive({
        title: null,
        description: null,
        created_at: new Date()
    })

    function logout() {
        localStorage.removeItem('auth')
        router.push('/sign-up')
    }

    function storeAnnouncement() {
        loading.value = true
        let data = new FormData();
        data.append('method', 'storeAnnouncement');
        data.append('title', announcementForm.title)
        data.append('description', announcementForm.description)
        data.append('created_at', announcementForm.created_at)

        fetch(`http://localhost/account-management-system-master/backend/index.php`,
        {
            method: 'POST',
            body: data,
        })
        .then((response) => {
            return response.text()
        })
        .then((data) => {
            console.log(data)
            createAccouncementDialog.value = false
            loading.value = false
        })
        .catch((error) => {
            createAccouncementDialog.value = false
            loading.value = false
        })
    }

    const required = value => !!value || 'Required.'
    const counter = value => value.length <= 70 || 'Max 70 characters'
          
</script>



<template>
    <v-layout>
        <v-app-bar color="teal-darken-4" image="https://picsum.photos/1920/1080?random">
            <template v-slot:image>
                <v-img gradient="to top right, rgba(19,84,122,.8), rgba(128,208,199,.8)"></v-img>
            </template>

            <v-app-bar-title>Account Management</v-app-bar-title>
            <v-spacer></v-spacer>

            <v-btn @click="createAccouncementDialog = true" prepend-icon="mdi-plus">
                New Event
            </v-btn>

            <router-link to="/admin/dashboard">
                <v-btn color="white" prepend-icon="mdi-view-dashboard-outline">
                    Dashboard
                </v-btn>
            </router-link>

            <router-link to="/admin/manage-users">
                <v-btn color="white" prepend-icon="mdi-account-supervisor-outline">
                    Manage users
                </v-btn>
            </router-link>

            <router-link to="#">
                <v-btn color="red" prepend-icon="mdi-logout" @click="logout()">
                    Logout
                </v-btn>
            </router-link>
            
        </v-app-bar>

        <v-main class="bg-grey-darken-3">
            <v-container>
                <slot/>
            </v-container>
        </v-main>
    </v-layout>

    <v-dialog v-model="createAccouncementDialog" width="80%">
        <v-card title="New announcement">
            <v-card-text>
                <v-text-field label="Title" v-model="announcementForm.title"></v-text-field>
                <v-textarea :rules="[required, counter]" counter="70" label="Description" v-model="announcementForm.description"></v-textarea>
            </v-card-text>
            <v-card-actions>
                <v-spacer/>
                <v-btn color="grey" @click="createAccouncementDialog = false">Cancel</v-btn>
                <v-btn color="green" @click="storeAnnouncement()" :loading="loading">Add</v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>

</template>

<style scoped>

    .link {
        text-decoration: none;
    }

</style>
