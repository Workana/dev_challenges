<template>
  <div id="container">
    <VoteCardContainer v-bind:valid-votes="validVotes" v-bind:issue-status="issueStatus" @emit-vote="emitVote"/>
    <h3 v-if="this.issueStatus === 'Voting'">
      Voting issue #{{issue}}
    </h3>
    <h3 v-else>
      Issue #{{issue}} voted <span v-show="avg !== null">• Average: {{avg}}</span>
    </h3>
    <button v-show="this.issueStatus === 'Finished'" @click="$router.push('/')">Join another issue</button>
    <h3>Connected {{members.length}}</h3>
    <MembersContainer v-bind:members="this.members" v-bind:issueStatus="this.issueStatus"/>
    <span class="error" v-show="error">{{errorMessage}}</span>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import VoteCardContainer from "../components/molecules/VoteCardContainer.vue";
import MembersContainer from "../components/molecules/MembersContainer.vue";
import authStorage from "../services/localStorage/authStorage";
import Pusher from 'pusher-js';
import lobby from "../services/api/lobby";
import {isError} from "../helpers/isError";

export default {
  name: 'Lobby',
  components: {VoteCardContainer, MembersContainer},
  data() {
    return {
      validVotes: [1,2,3,5,8,13,20,40,'?'],
      issue: null,
    };
  },
  computed: {
    you() { return this.members[0] },
    ...mapState({
      members: state => state.lobby.members,
      issueStatus: state => state.lobby.issueStatus,
      avg: state => state.lobby.avg,
      error: state => state.error.isError,
      errorMessage: state => state.error.message
    }),
  },
  created () {
    this.subscribe();
    this.issue = this.$route.params.issue;
  },
  mounted() {
    if(!authStorage.getSession()){
      this.$router.push('/signup')
    }
    this.$store.dispatch('lobby/getIssue', this.issue)
  },
  methods: {
    subscribe() {
      let pusher = new Pusher(process.env.VUE_APP_PUSHER_KEY, { cluster: process.env.VUE_APP_PUSHER_CLUSTER });
      pusher.subscribe(this.$route.params.issue);
      pusher.bind('user-joined', data => {
        this.$store.dispatch('lobby/updateIssue', data)
      });
      pusher.bind('user-voted', data => {
         this.$store.dispatch('lobby/updateIssue', data)
      })
    },
    async emitVote(vote) {
      await this.$store.dispatch('error/clearError', null, { root: true });
      const response = await lobby.vote(this.issue, vote);
      const { status } = response;
      if (isError(status)) {
        await this.$store.dispatch('error/setError', `Something went wrong`, { root: true });
      }
    }
  }
}
</script>


<style scoped>
#container {
  max-width: 550px;
  margin: auto;
}
</style>
