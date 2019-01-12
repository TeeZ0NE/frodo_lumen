<template>
    <ul class="nav">
        <li v-for="(navItem, index) in navItems">
            <span :class="{'nav-active': isNavActive(index)}" @click="$emit('toHome')">{{navItem.title}}</span>
            <span v-if="isNavActive(index)">{{navSpacer}}</span>
        </li>
    </ul>
</template>

<script>
export default {
    name: 'NavMenu',
    props: {
        navItems: Array
    },
    data(){
     return {
        navSpacer: " >"
        } 
    },
    computed: {
        itemsCount: function () {
            return this.navItems.length;
        }
    },
    methods:{
        isNavActive: function (index) {
            // this.isPosts = this.itemsCount >= 2 ? true : false;
            return this.itemsCount - (++index);
        }
    }
}
</script>
<style lang="stylus">
$thead_bgc = #5178ff
.nav
    list-style-type none
    padding  0
    li
        display inline
        margin-left 5px
.nav-active
    color $thead_bgc
    cursor pointer
</style>