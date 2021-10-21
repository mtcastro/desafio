<template>
    <div class="page-template">
        <slot></slot>
    </div>
</template>

<script>

    export default {
        name: 'PageTemplate',
    }
</script>

<style lang="scss">
    html, body {
        background-color: #F8F8F8;
        margin: 0;
        padding: 0;
        height: 100%;
    }

    #__nuxt, #__layout{
        height: 100%
    }

    .page-template{
        position: relative;
        height: 100%;

    }
</style>
