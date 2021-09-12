<template>
    <ul id="voteList">
      <li v-for="vote in validVotes" :key="vote">
        <Card v-bind:selected="vote === cardVoted" v-bind:disabled="issueStatus === 'Finished'" @select-card="selectCard(vote)">{{vote}}</Card>
      </li>
    </ul>
</template>

<script>
import Card from "../atoms/Card.vue";
export default {
  name: "VoteCardContainer",
  components: {Card},
  props: {validVotes: Array, issueStatus: String},
  data() {
    return {
      cardVoted: null,
    }
  },
  methods: {
    selectCard(vote) {
      this.cardVoted = vote;
      this.$emit('emit-vote', this.cardVoted);
    },
  },
}
</script>

<style scoped>

#voteList {
  margin: 10px auto;
  padding: 0;
  justify-content: center;
  display: flex;
  flex-wrap: wrap;
  list-style: none;
}

</style>
