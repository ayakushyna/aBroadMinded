<template>
<div>
    <div class="container home">
        <b-row class="align-items-center text-center text-md-left">
            <div class="col-md-6 col-lg-5 mb-5 mb-md-0 hero-banner">
                <h1>Travel More To Discover Yourself</h1>
                <p> In our modern world a lot of people travel to other countries threw the seas, oceans. Some people travel by car others by plane or ships. Many of us like travelling.It can also broaden our minds. We feel excited when we go abroad and we see a different culture, habits and we hear a different language. Young people, who go abroad often become more independent and they have a chance to develop their skills, for example in comunication with others in foregin language. People travel during holidays or even work.</p>
                <b-button pill size="lg" variant="primary" :to="{ name: 'PropertySearch'}">Get Started</b-button>
            </div>
            <div class="col-md-6 col-lg-7 col-xl-6 offset-xl-1">
                <img class="img-fluid" src="home_main.svg" alt="">
            </div>
        </b-row>
    </div>
</div>

    <!--================Search Package section End =================-->

</template>
<script>
    import {BButton, BCard, BCol, BCollapse, BRow} from 'bootstrap-vue'

    export default {

        components: {
            BButton,
            BCollapse,
            BCard,
            BRow, BCol
        }
    }
</script>
