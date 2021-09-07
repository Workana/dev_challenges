<template>
  <div id="container">
    <VoteCardContainer v-bind:valid-votes="validVotes" @emitVote="emitVote"/>
    <h3>
      Voting issue #{{issue}} • Connected {{members.length}}
    </h3>
    <button v-show="this.issueStatus === 'Voted'">Reveal Cards</button>
    <MembersContainer v-bind:members="this.members" v-bind:issueStatus="this.issueStatus"/>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import VoteCardContainer from "../components/molecules/VoteCardContainer";
import MembersContainer from "../components/molecules/MembersContainer";
import authStorage from "../services/localStorage/authStorage";

export default {
  name: 'Lobby',
  components: {VoteCardContainer, MembersContainer},
  data() {
    return {
      validVotes: [1,2,3,5,8,13,20,40,'?'],
    };
  },
  computed: {
    you() { return this.members[0] },
    ...mapState({
                issue: state => state.lobby.issue,
               members: state => state.lobby.members,
                issueStatus: state => state.lobby.issueStatus
    }),
  },
  mounted() {
    authStorage.setSession('fdggfdfdfgdfdgfdgf')
    if(authStorage.getSession() === ''){
      this.$router.push('/signup')
    }
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
