<template>
    <table class="table table-striped">
        <thead class="table-dark">
        <tr>
            <th>Team name</th>
            <th>P</th>
            <th>W</th>
            <th>D</th>
            <th>L</th>
            <th>GD</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="result in sortedStandings" :key="result.id">
            <td>{{ teams[result.team_id].name }}</td>
            <td>{{ result.points }}</td>
            <td>{{ result.wins }}</td>
            <td>{{ result.drafts }}</td>
            <td>{{ result.loses }}</td>
            <td>{{ result.goals_diff }}</td>
        </tr>
        </tbody>
    </table>
</template>


<script>
import {reverse, sortBy} from "lodash";

export default {
    props: {
        teams: Array,
        standings: Array,
    },
    computed: {
        sortedStandings(){
            return reverse(sortBy(this.standings, (o) => parseInt(o.points)));
        }
    }
}
</script>
