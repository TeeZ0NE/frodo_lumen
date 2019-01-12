<template>
    <p v-bind:class="[ hasError ? 'errorMsg' : '' ]">{{message}}</p>
</template>

<script>
export default {
    name: 'UserMessage',
    props: {
        message: String,
        hasError: {
            type: Boolean,
            default: false
        }
    }
}
</script>

<style lang="stylus">
$error_bg = #e09393
$error_border = #dd6767
$msg_border = #00582a 
.msg
	border-radius .4em
	border: 1px solid $msg_border
	margin 1em 2em
	padding 1em
	text-align center
.errorMsg
	background-color $error_bg
	border: 1px solid $error_border
</style>
