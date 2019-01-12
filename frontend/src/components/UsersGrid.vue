<template>
    <table>
		<thead>
		<tr>
			<th v-for="key in columns" :key="key">
				{{ key }}
			</th>
		</tr>
		</thead>
		<tbody>
		<tr v-for="(channel, index) in channels" :key="channel.id">
			<td>{{ index }}</td>
			<td><a :href="url+channel.screen_name">{{ channel.screen_name }}</a></td>
			<td>{{ channel.name }}</td>
			<td>{{ channel.posts_number }}</td>
			<td>{{ channel.refresh_interval }}</td>
			<td>
            <a href="#" @click.prevent="$emit('onEditUser', channel.screen_name, channel.refresh_interval, channel.name)">Edit </a>/ 
            <a href="#" v-if="channel.posts_number" @click.prevent="$emit('onViewPosts',channel.screen_name)"><span>Posts</span></a>
            <span v-else>Posts</span> / 
            <a href="#" @click.prevent="$emit('onDeleteUser', channel.screen_name, index)">Delete</a></td>
		</tr>
		</tbody>
	</table>
</template>

<script>
export default {
  name: 'UsersGrid',
  props: {
    channels: [Object, Array],
    url: String,
    columns: Array
  }
}
</script>
