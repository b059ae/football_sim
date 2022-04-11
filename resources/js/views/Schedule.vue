<template>
    <div>
        <h1 class="text-center">Schedule</h1>

        <div class="row vh-50">
            <div v-for="(games, week) in schedule" :key="week" class="col-3">
                <WeekCard :teams="standingsTeams" :games="games" :week="week"/>
            </div>

        </div>

        <div class="text-center">
            <router-link :to="{name : 'standings'}" v-if="inProgress" class="btn btn-lg btn-primary">
                Standings
            </router-link>
        </div>
    </div>
</template>


<script>
import groupBy from 'lodash/groupBy';
import keyBy from 'lodash/keyBy';
import {mapState} from "vuex";
import WeekCard from "../components/WeekCard";

export default {
    components: {WeekCard},
    computed: {
        ...mapState(['teams', 'status', 'games']),
        standingsTeams() {
            return keyBy(this.teams, 'id');
        },
        inProgress() {
            return this.status === 'in_progress';
        },
        schedule() {
            return groupBy(this.games, (i) => i.week);
        }
    },
    mounted() {
        this.$store.dispatch("getStatus");
        this.$store.dispatch("getTeams");
        this.$store.dispatch("getGames");
    }
}
</script>
