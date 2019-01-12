<template>
    <div class="add-new-channel">
        <button @click="$emit('onAddNewUser')">Add new channel</button>
    </div>
</template>
<script>
export default {
    name: "AddNewUserBtn"
}
</script>

<style lang="stylus">
	.add-new-channel
		align-content center
		display grid
		grid-area add-btn
		justify-content end
		margin-right 2em

	button
		height 30px
</style>