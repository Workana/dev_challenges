<template>
  <div id="container">
    <VoteCardContainer v-bind:valid-votes="validVotes" v-bind:issue-status="issueStatus" @emitVote="emitVote"/>
    <h3 v-if="this.issueStatus === 'Voting'">
      Voting issue #{{issue}}
    </h3>
    <h3 v-else>
      Issue #{{issue}} voted <span v-show="avg !== null">• Average: {{avg}}</span>
    </h3>
    <button v-show="this.issueStatus === 'Finished'" @click="$router.push('/')">Join another issue</button>
    <h3>Connected {{members.length}}</h3>
    <MembersContainer v-bind:members="this.members" v-bind:issueStatus="this.issueStatus"/>
  </div>
</template>

<script>
import { mapState } from 'vuex'
import VoteCardContainer from "../components/molecules/VoteCardContainer";
import MembersContainer from "../components/molecules/MembersContainer";
import authStorage from "../services/localStorage/authStorage";
import Pusher from 'pusher-js';

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
                avg: state => state.lobby.avg
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
    emitVote(vote) {
      this.$store.dispatch('lobby/vote', {issue: this.issue, vote})
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
