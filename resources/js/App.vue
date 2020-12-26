<template>
    <div id="app">
        <TheContainer></TheContainer>

    </div>
</template>

<script>
    import Appheader from "./components/Appheader.vue";
    import TheContainer from "./containers/TheContainer.vue";
    
  
    import wi from "./components/wi.vue";
    export default {
        name: "app",
        components: {
            Appheader,
            wi,
            TheContainer,
          
       
        }
    };
</script>

<style lang="scss">
    @import 'assets/scss/style';
</style>
