<template>
  <table>
    <thead>
      <tr>
        <th v-for="key in columns"
        @click="sortBy(key)"
        :class="{ active: sortKey == key }" :key="key">
        {{ key | capitalize }}
        <span class="arrow" :class="sortOrders[key] > 0 ? 'asc' : 'dsc'">
        </span>
      </th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(entry, index) in filteredData" :key="index">
      <td v-for="key in columns" :key="key">
        {{entry[key]}}
      </td>
    </tr>
  </tbody>
</table>
</template>

<script>
export default{
    name: "PostsGrid",
    props:{
        posts: [Array, Object],
        columns: Array
    },
  data: function () {
    var sortOrders = {}
    this.columns.forEach(function (key) {
      sortOrders[key] = 1
    })
    return {
      sortKey: '',
      sortOrders: sortOrders
    }
  },
  computed: {
    filteredData: function () {
      var sortKey = this.sortKey
      var filterKey = this.filterKey && this.filterKey.toLowerCase()
      var order = this.sortOrders[sortKey] || 1
      var data = this.posts
      if (filterKey) {
        data = data.filter(function (row) {

          return Object.keys(row).some(function (key) {

            return String(row[key]).toLowerCase().indexOf(filterKey) > -1
          })
        })
      }
      if (sortKey) {
        data = data.slice().sort(function (a, b) {
          a = a[sortKey]
          b = b[sortKey]

          return (a === b ? 0 : a > b ? 1 : -1) * order
        })
      }

      return data
    }
  },
  filters: {
    capitalize: function (str) {
      return str.charAt(0).toUpperCase() + str.slice(1)
    }
  },
  methods: {
    sortBy: function (key) {
      this.sortKey = key
      this.sortOrders[key] = this.sortOrders[key] * -1
    }
  }
}
</script>
<style lang="stylus">
$thead_bgc = #5178ff
$tbody_bgc = #9eccff
.arrow
    display inline-block
    vertical-align middle
    width 0
    height 0
    margin-left 5px
    opacity 0.66
    &.asc
        border-left 4px solid transparent
        border-right 4px solid transparent
        border-bottom 4px solid #fff

    &.dsc
        border-left 4px solid transparent
        border-right 4px solid transparent
        border-top 4px solid #fff
table
    th
        color $tbody_bgc
        &.active
            color #fff
        &.arrow
            opacity 1
</style>
