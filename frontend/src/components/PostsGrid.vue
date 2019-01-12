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
            <tr v-for="(post, index) in posts" :key="post.id_str">
                <td>{{index+1}}</td>
                <td>{{post.id_str}}</td>
                <td>{{post.created_at}}</td>
                <td>{{post.title}}</td>
                <td>{{post.description}}</td>
                <td>{{post.favorite_count}}</td>
                <td>{{post.replies_count}}</td>
                <td>{{post.retweet_count}}</td>
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
    }
}
</script>