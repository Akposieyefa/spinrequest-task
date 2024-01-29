<template>
    <router-view></router-view>
    <vue3-progress-bar></vue3-progress-bar>
</template>

<script>
import {useStore} from "vuex";
import {onUpdated} from "vue";

export default {
    name: "App",
    setup() {
        const store = useStore();
        const userProfile = async  () =>  {
            let api_url = process.env.MIX_API_BASE_URL + 'profiles'
            const response = await axios.get( api_url, {
                headers: { Authorization: `Bearer ${localStorage.getItem('token')}` }
            });
            await store.commit("user", response.data.data);
        }
        onUpdated( async  () => {
            await  userProfile()
        });
        return { userProfile }
    }
}
</script>

<style scoped>

</style>


