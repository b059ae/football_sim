<template >
    <table class="table table-striped">
        <thead class="table-dark">
        <tr>
            <th>Team name</th>
            <th>Power</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="result in teams" :key="result.id">
            <td>{{ result.name }}</td>
            <td>{{ result.power }}</td>
        </tr>
        </tbody>
    </table>
</template>



<script>
export default {
    props : {
        teams : Array,
    }
}
</script>
