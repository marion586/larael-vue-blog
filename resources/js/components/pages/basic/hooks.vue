<template>
    <div>
        <h1 ref="myref">this a my hook tutorial</h1>
        <p>My name : is {{name}}</p>
    </div>
</template>

<script>
export default {
    data(){
        return {
            name: 'sadek'
        }
    },
    breforeCreate(){
        // can't acces data property and method

        console.log(this.name);
        //use for auth
    }
    ,
    created(){
        //use to call our Api our data
        // at created , the html is not available
        console.log(this.$refs.myref) //it 's going to be undefined because html is still not available

        //call mostly initial data from it...//this can acces to data property , computed , everything related to vuejs

        console.log('data and other function is available but not html' ,this.name);
    },
    mounted(){
        //acces local storage , access html element
        //created is instanced even before html is rendered
        //mounted is only instanced after html is build
        console.log(this.$refs.myref)
    }

}
</script>