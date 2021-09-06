<template>
  <div id="container">
    <VoteCardContainer v-bind:valid-votes="validVotes" @emitVote="emitVote"/>
    <h3>
      Voting issue #<input id="issue" type="number" v-model="issue" /> • Connected {{members.length}}
    </h3>
    <MembersContainer v-bind:members="this.members"/>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import VoteCardContainer from "../components/molecules/VoteCardContainer";
import MembersContainer from "../components/molecules/MembersContainer";

export default {
  name: 'Lobby',
  components: {VoteCardContainer, MembersContainer},
  data() {
    return {
      validVotes: [1,2,3,5,8,13,20,40,'?'],
      responsesDemo: {
        php: null,
        node: null,
      }
    };
  },
  computed: {
    you() { return this.members[0] },
    ...mapState({
                issue: state => state.lobby.issue,
               members: state => state.lobby.members
    }),
  },
  mounted() {
    this.demoResponses();
    this.$store.dispatch('lobby/getIssue')
  },
  methods: {
    emitVote(vote) {
      if (vote === this.you.vote) {
        this.you.vote = false;
        return;
      }
      this.you.vote = vote;
    },
    async demoResponses() {
      const resPhp = await fetch('http://localhost:8081/issue/232');
      this.responsesDemo.php = JSON.stringify(await resPhp.json());
      const resNode = await fetch('http://localhost:8082/issue/232');
      this.responsesDemo.node = JSON.stringify(await resNode.json());
    }
  }
}
</script>


<style scoped>
#container {
  max-width: 550px;
  margin: auto;
}
#issue {
  color: #2a9d8f;
  width: 75px;
  text-align: center;
}
</style>
