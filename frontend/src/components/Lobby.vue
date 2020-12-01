<template>
  <div id="container">
    <div class="vote">
      <ul id="voteList">
        <li v-for="vote in validVotes"
            :key="vote"
            :class="{voted: you.vote === vote}"
            @click="emitVote(vote)">{{vote}}</li>
      </ul>
    </div>
    <div class="members">
      <h3>
        Voting issue #<input id="issue" type="number" v-model="issue" /> • Connected {{members.length}}
      </h3>
      <ul id="memberList">
        <li :key="member.name" v-for="member in members">
          <div class="status">{{member.vote ? '✅' : ''}}</div>
          <div class="name">{{member.name}}</div>
          <div class="vote">{{member.vote ? member.vote : '-'}}</div>
        </li>
      </ul>
    </div>

    <p>🎹 Get complete instructions at <a href="https://github.com/workana/hiring_challenge">Workana Hiring Challenge</a>.</p>
    <hr />
<pre style="text-align: left;">
        <strong>PHP res:</strong>
        {{responsesDemo.php}}

        <strong>Node res:</strong>
        {{responsesDemo.node}}
</pre>

  </div>
</template>

<script>
export default {
  name: 'Lobby',
  data() {
    return {
      issue: 234,
      validVotes: [1,2,3,5,8,13,20,40,'?'],
      members: [
        {name: 'Julian (you)', vote: false},
        {name: 'Flor', vote: false},
        {name: 'Gino', vote: false}
      ],
      responsesDemo: {
        php: null,
        node: null,
      }
    };
  },
  computed: {
    you() { return this.members[0] },
  },
  async mounted() {
    this.demoResponses();
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

</style>
