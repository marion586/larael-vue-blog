<template>
    <div>
        <h1>the number is {{counter}}</h1>
        <button @click="updateCounter(1)">increase</button>
        <button @click="updateCounter(-1)">decrease</button>
         <br>
         <br>
         <hr>

        <div v-for="(blog , i ) in blogs" v-bind:key = "i">
            <div v-if="blog.id != 1">

                <h1>{{blog.title}}</h1>
                <p>{{blog.post}}</p>
            </div>
           
        </div>


        <br>
        <br>

        <div>

            <h1 v-if="showItem">show this item if " showItem is true</h1>

             <h1 v-else>show this item if " showItem is false</h1>
        </div>

            <button @click="showItem =!showItem">Change showItem</button>


    </div>
</template>

<script>

export default {
    data(){
        return {
            views: 0,
            blogs: [],
            showItem : false
        }
    },
    methods: {
        updateCounter(number){
            this.views+= number
        },

    },
    created(){
        // call the server to get views of this blog post ...
        this.counter = 100 
        //get the blog posts
        let posts= [
                {
                    title : 'this is blog title1',
                    post : 'this is the blog post1',
                    id : 1
                },
                  {
                    title : 'this is blog title2',
                    post : 'this is the blog post2',
                    id : 2
                },
                  {
                    title : 'this is blog title3',
                    post : 'this is the blog pos0t3',
                    id : 3
                }
            ]

            this.blogs = posts;

    }
}
</script>