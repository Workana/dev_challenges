<template>
  <div :class="{selected: this.selected, disabled: this.disabled}" @click="!disabled ? $emit('select-card') : null">
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: "Card",
  props: ['selected', 'disabled'],
}
</script>

<style scoped>
div {
  box-sizing: border-box;
  cursor: pointer;
  height: 100px;
  width: 100px;
  padding: 30px 0;
  border-radius: 9px;
  box-shadow: 2px 2px 2px #000;
  text-shadow: 1px 1px 2px #444;
  background: #e76f51;
  color: #fff;
  margin: 10px;
  font-size: 30px;
  transition: background-color 0.3s ease font-size 0.3s ease;
}
div.selected {
  font-size: 33px;
  background: #132a55;
}
div.disabled {
  cursor: default;
}
</style>
