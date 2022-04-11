<template>
    <div class="w-50 mx-auto">
        <h1 class="text-center">Championship</h1>
        <div class="vh-50">
            <TeamsTable :teams="teams"/>
        </div>

        <div class="text-center">
            <router-link :to="{name : 'schedule'}" v-if="inProgress" class="btn btn-lg btn-primary">
                Schedule
            </router-link>
            <button type="button" v-if="notStarted" class="btn btn-lg btn-primary" @click="generateFixtures">
                Generate Fixtures
            </button>
        </div>
    </div>
</template>


<script>
import axios from "axios";
import TeamsTable from "../components/TeamsTable";
import {mapState} from "vuex";

export default {
    components: {TeamsTable},
    computed: {
        ...mapState(['teams', 'status']),

        inProgress() {
            return this.status === 'in_progress';
        },
        notStarted() {
            return this.status === 'not_started';
        }
    },
    mounted() {
        this.$store.dispatch("getStatus");
        this.$store.dispatch("getTeams");
    },
    methods: {
        generateFixtures() {
            axios.post('/api/games/generate').then((res) => {
                this.$router.replace({name: 'schedule'})
            }).catch((err) => {
                alert(err);
            })
        }
    }
}
</script>
