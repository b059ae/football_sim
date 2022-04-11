<template>
    <table class="table table-striped">
        <thead class="table-dark">
        <tr>
            <th colspan="3">Week {{ week }}</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="game in games" :key="game.id">
            <td class="w-40">{{ teams[game.team_a].name }}</td>
            <td v-if="game.team_a_goals === null" class="w-10">v</td>
            <td v-else class="w-10">{{game.team_a_goals}}:{{game.team_b_goals}}</td>
            <td class="w-40">{{ teams[game.team_b].name }}</td>
        </tr>
        </tbody>
    </table>
</template>


<script>
export default {
    props: {
        week: Number,
        teams: Array,
        games: Array,
    }
}
</script>
