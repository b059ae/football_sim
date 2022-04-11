<template>
    <div>
        <h1 class="text-center">Standings</h1>
        <div class="row vh-50">
            <div class="col-6">
                <StandingsTable :teams="standingsTeams" :standings="standings"/>
            </div>
            <div class="col-3">
                <WeekCard v-if="lastGames.length" :teams="standingsTeams" :games="lastGames" :week="lastWeek"/>
                <WeekCard v-if="nextGames.length" :teams="standingsTeams" :games="nextGames" :week="nextWeek"/>
            </div>
            <div v-if="inProgress" class="col-3">
                <WinnersCard :teams="standingsTeams" :winners="winners"/>
            </div>
        </div>

        <div class="text-center">
            <button type="button" v-if="inProgress" class="btn btn-lg btn-primary mx-2" @click="playAllWeeks">
                Play All Weeks
            </button>
            <button type="button" v-if="inProgress" class="btn btn-lg btn-primary mx-2" @click="playNextWeek">
                Play Next Week
            </button>
            <button type="button" class="btn btn-lg btn-danger mx-2" @click="resetData">
                Reset Data
            </button>
        </div>
    </div>
</template>


<script>
import keyBy from "lodash/keyBy";
import {mapState} from "vuex";
import WeekCard from "../components/WeekCard";
import StandingsTable from "../components/StandingsTable";
import WinnersCard from "../components/WinnersCard";
import axios from "axios";

export default {
    components: {StandingsTable, WeekCard, WinnersCard},
    computed: {
        ...mapState(['teams', 'standings', 'winners', 'nextGames', 'lastGames', 'status']),
        standingsTeams() {
            return keyBy(this.teams, 'id');
        },
        lastWeek() {
            const games = this.lastGames;
            return games.length > 0 ? games[0].week : null;
        },
        nextWeek() {
            const games = this.nextGames;
            return games.length > 0 ? games[0].week : null;
        },
        inProgress() {
            return this.status === 'in_progress';
        }
    },
    mounted() {
        this.$store.dispatch("getTeams");
        this.updateData();
    },
    methods: {
        playAllWeeks() {
            axios.post('/api/games/playAll').then((res) => {
                this.updateData();
            }).catch((err) => {
                alert(err);
            })
        },
        playNextWeek() {
            axios.post('/api/games/playNext').then((res) => {
                this.updateData();
            }).catch((err) => {
                alert(err);
            })
        },
        resetData() {
            axios.post('/api/games/reset').then((res) => {
                this.$router.push({name: 'welcome'})
            }).catch((err) => {
                alert(err);
            })
        },
        async updateData(){
            this.$store.dispatch("getStatus");
            this.$store.dispatch("getWinners");
            this.$store.dispatch("getNextGames");
            this.$store.dispatch("getLastGames");
            this.$store.dispatch("getStandings");
        }

    }
}
</script>
