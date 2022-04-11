<template >
    <table class="table table-striped">
        <thead class="table-dark">
        <tr>
            <th>Champion Prediction</th>
            <th>%</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="result in probability" :key="result.id">
            <td>{{ teams[result.team_id].name }}</td>
            <td>{{ result.percentage }}</td>
        </tr>
        </tbody>
    </table>
</template>



<script>
import {reverse, sortBy} from "lodash";

export default {
    props : {
        teams : Array,
        winners : Array,
    },
    computed: {
        probability(){
            const winners = this.winners.map(obj => {
                return {...obj, percentage: (obj.probability*100).toFixed(1)}
            });
            return reverse(sortBy(winners, (o) => parseFloat(o.probability)));
        }
    }
}
</script>
