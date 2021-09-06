<template>
  <div id="app">
    <Header/>
    <router-view />
  </div>
</template>

<script>

import Header from "./components/molecules/Header";

export default {
  name: 'App',
  components: {Header},
}
</script>

<style>
body {
  box-sizing: border-box;
  font-family: Arial;
  margin: 0;
  background: #fff;
  text-align: center;
}

h1 {
  margin: 0px;
  color: #e76f51;
  text-shadow: 2px 2px 2px #ccc;
}
h2 {
  margin: auto;
  color: #e76f51;
  font-size: 1em;
  text-shadow: 1px 1px 2px #ccc;
  text-align: center;
}
h3 {
  color: #2a9d8f;
  text-shadow: 2px 2px 2px #ccc;
}
</style>
