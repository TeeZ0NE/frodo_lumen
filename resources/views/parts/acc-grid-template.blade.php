<script type="text/x-template" id="grid-template">
	<table>
		<thead>
		<tr>
			<th v-for="key in columns">
				@{{ key }}
			</th>
		</tr>
		</thead>
		<tbody>
		<tr v-for="(channel, index) in channels" :key="channel.id">
			<td>@{{ index }}</td>
			<td><a :href="url+channel.screen_name">@{{ channel.screen_name }}</a></td>
			<td>@{{ channel.name }}</td>
			<td>@{{ channel.posts_number }}</td>
			<td>@{{ channel.refresh_interval }}</td>
			<td>
            <a href="#" @click.prevent="onEditUser">Edit </a>/ 
            <a href="#" v-if="channel.posts_number" @click.prevent="onViewPosts(channel.screen_name)"><span>Posts</span></a>
            <span v-else>Posts</span> / 
            <a href="#" @click.prevent="onDeleteUser(channel.screen_name, index)">Delete</a></td>
		</tr>
		</tbody>
	</table>
</script>