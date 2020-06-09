<template>
    <div>
        <h1 class="text-center" >Admin Dashboard</h1>
        <br>
        <b-row>
            <b-col>
                <h3 class="text-center">Properties by Types</h3>
                <doughnut v-if="typesReady"
                          :chartData="chartDataTypes"
                          :width="300" :height="300"
                          :options="options"
                          id="property_types">
                </doughnut>
            </b-col>

            <b-col>
                <h3 class="text-center">Busy Properties at Specific Day</h3>
                <b-row style="justify-content: center">
                    <el-date-picker
                        class="col-sm-4"
                        v-model="date"
                        type="date"
                        required
                        placeholder="Pick a Date"
                        format="yyyy/MM/dd"
                        value-format="yyyy-MM-dd">
                    </el-date-picker>

                    <b-button @click="getBusyProperties">Submit</b-button>
                </b-row>


                <doughnut v-if="busyPropertiesReady"
                          :chartData="chartDataBusy"
                          :width="300" :height="300"
                          :options="options"
                          id="busy_properties">
                </doughnut>
            </b-col>
        </b-row>
        <br>
        <b-row>
            <b-col>
                <h3 class="text-center">Countries Rank by Profit</h3>
                <b-row style="justify-content: center">

                    <el-date-picker
                        v-model="profit_range"
                        class="col-sm-4"
                        type="daterange"
                        :default-time="['03:00:00', '03:00:00']"
                        :picker-options="datePickerOptions"
                        align="left"
                        start-placeholder="Start Date"
                        end-placeholder="End Date"
                        format="yyyy/MM/dd"
                        value-format="yyyy-MM-dd">
                    </el-date-picker>

                    <b-button @click="getProfitByCountry">Submit</b-button>
                </b-row>


                <b-table-simple hover small caption-top responsive v-if="profit_countries_items" class="mt-3">
                    <b-thead head-variant="dark">
                        <b-tr>
                            <b-th >Name</b-th>
                            <b-th >Profit, $</b-th>
                            <b-th >Rank</b-th>
                        </b-tr>
                    </b-thead>
                    <b-tbody>
                        <b-tr v-for="(item, key) in profit_countries_items" :key="key">
                            <b-td> {{item.name }}</b-td>
                            <b-td>{{item.value }}</b-td>
                            <b-td>{{item.rank }}</b-td>
                        </b-tr>
                    </b-tbody>
                </b-table-simple>
            </b-col>
            <b-col>
                <h3 class="text-center">Countries Rank by Bookings Count</h3>
                <b-row style="justify-content: center">

                    <el-date-picker
                        v-model="count_range"
                        class="col-sm-4"
                        type="daterange"
                        :default-time="['03:00:00', '03:00:00']"
                        :picker-options="datePickerOptions"
                        align="left"
                        start-placeholder="Start Date"
                        end-placeholder="End Date"
                        format="yyyy/MM/dd"
                        value-format="yyyy-MM-dd">
                    </el-date-picker>

                    <b-button @click="getBookingCountByCountry">Submit</b-button>
                </b-row>


                <b-table-simple hover small caption-top responsive v-if="count_countries_items" class="mt-3">
                    <b-thead head-variant="dark">
                        <b-tr>
                            <b-th >Name</b-th>
                            <b-th >Count, $</b-th>
                            <b-th >Rank</b-th>
                        </b-tr>
                    </b-thead>
                    <b-tbody>
                        <b-tr v-for="(item, key) in count_countries_items" :key="key">
                            <b-td> {{item.name }}</b-td>
                            <b-td>{{item.value }}</b-td>
                            <b-td>{{item.rank }}</b-td>
                        </b-tr>
                    </b-tbody>
                </b-table-simple>
            </b-col>
        </b-row>

    </div>
</template>

<script>
    import {
        BRow, BCol, BForm, BFormGroup, BFormSelect, BFormInput, BButton, BCard, BTableSimple, BTd, BTr, BTh,BTbody, BThead
    } from 'bootstrap-vue'
    import Doughnut from '../../components/Doughnut'
    import axios from "axios";
    import Line from "../../components/Line";

    export default {
        data() {
            return {
                date: "",
                country_id: null,
                countries: [],

                typesReady:false,
                chartDataTypes: {
                    labels: [],
                    datasets: [{
                        borderWidth: 1,
                        borderColor: [
                            'rgb(245,131,43, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(35,38,229,1)',
                            'rgba(196,54,206,1)',
                            'rgba(227,13,13,1)',
                            'rgb(245,131,43, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(35,38,229,1)',
                            'rgba(196,54,206,1)',
                            'rgba(227,13,13,1)',
                        ],
                        backgroundColor: [
                            'rgba(245,131,43, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(35,38,229, 0.2)',
                            'rgba(196,54,206, 0.2)',
                            'rgba(227,13,13, 0.2)',
                            'rgba(245,131,43, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(35,38,229, 0.2)',
                            'rgba(196,54,206, 0.2)',
                            'rgba(227,13,13, 0.2)',
                        ],
                        data: []
                    }, {
                        borderWidth: 1,
                        borderColor: [
                            'rgba(245,131,43, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(35,38,229,1)',
                            'rgba(196,54,206,1)',
                            'rgba(227,13,13,1)',
                            'rgba(245,131,43, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(35,38,229,1)',
                            'rgba(196,54,206,1)',
                            'rgba(227,13,13,1)',
                        ],
                        backgroundColor: [
                            'rgb(245,131,43, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(35,38,229, 0.2)',
                            'rgba(196,54,206, 0.2)',
                            'rgba(227,13,13, 0.2)',
                            'rgba(245,131,43, 0.2)',
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(35,38,229, 0.2)',
                            'rgba(196,54,206, 0.2)',
                            'rgba(227,13,13, 0.2)',
                        ],
                        data: []
                    }]
                },

                busyPropertiesReady:false,
                chartDataBusy: {
                    labels: [],
                    datasets: [{
                        borderWidth: 1,
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)',
                        ],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(245,131,43, 0.2)',
                        ],
                        data: []
                    }]
                },

                countriesReady:false,
                profit_range: [],
                profit_countries_items: null,
                count_range: [],
                count_countries_items: null,
                datePickerOptions: {
                    disabledDate: this.disabledDate
                },
                chartDataCountries: {
                    labels: [],
                    datasets: [{
                        borderWidth: 1,
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)',
                        ],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(245,131,43, 0.2)',
                        ],
                        data: []
                    }]
                },

                options: {
                    legend: {
                        display: true
                    },
                    responsive: true,
                    maintainAspectRatio: false
                }
            }
        },
        mounted() {
            this.getGroupByPropertyTypes();
            this.getCountries();
        },
        methods: {
            disabledDate (date) {
                return date > new Date()
            },
            getProfitByCountry() {
                axios.post(this.$route.meta.api.countries + '/profit_ranking', {
                    start_date: this.profit_range[0],
                    end_date: this.profit_range[1],
                })
                    .then((response) => {
                        this.profit_countries_items = response.data.items
                        console.log(this.profit_countries_items)
                    })
            },
            getBookingCountByCountry() {
                axios.post(this.$route.meta.api.countries + '/booking_ranking', {
                    start_date: this.count_range[0],
                    end_date: this.count_range[1],
                })
                    .then((response) => {
                        this.count_countries_items = response.data.items
                        console.log(this.count_countries_items)
                    })
            },
            getBusyProperties() {
                axios.get(this.$route.meta.api.properties + '/busy/' + this.date)
                    .then((response) => {
                        let properties_count = response.data.items;
                        this.busyPropertiesReady = false;
                        this.chartDataBusy.labels = []
                        this.chartDataBusy.datasets[0].data = []

                        console.log(properties_count)
                        this.chartDataBusy.datasets[0].data.push(properties_count[0].free, properties_count[0].busy)
                        this.chartDataBusy.labels.push('Free', 'Busy')

                        this.$nextTick(() => {
                            this.busyPropertiesReady = true;
                        })

                        console.log(this.chartDataBusy);
                    })

            },
            getGroupByPropertyTypes() {
                axios.get(this.$route.meta.api.property_types + '/count')
                    .then((response) => {
                        let property_types = response.data.items;
                        this.typesReady = false;
                        this.chartDataTypes.labels = []
                        this.chartDataTypes.datasets[0].data = []

                        console.log(property_types)
                        for (let i in property_types) {
                            this.chartDataTypes.datasets[0].data.push(property_types[i].count)
                            this.chartDataTypes.labels.push(property_types[i].name)
                        }

                        axios.get(this.$route.meta.api.properties + '/host_types/count')
                            .then((response) => {
                                let host_types = response.data.items;
                                this.chartDataTypes.datasets[1].data = []

                                console.log(host_types)
                                let length = this.chartDataTypes.labels.length
                                for (let i = 0; i < host_types.length; ++i) {
                                    let length = this.chartDataTypes.labels.length
                                    this.chartDataTypes.datasets[0].data[length] = 0
                                    this.chartDataTypes.datasets[1].data[length] = host_types[i].count
                                    this.chartDataTypes.labels.push(host_types[i].name)
                                }

                                this.$nextTick(() => {
                                    this.typesReady = true;
                                })
                                console.log(this.chartDataTypes);
                            })
                    })
            },
        },
        components: {
            Line,
            Doughnut,BRow, BCol, BForm, BFormGroup, BFormSelect, BFormInput, BButton, BCard,BTableSimple, BTd, BTr, BTh, BTbody, BThead
        }
    }
</script>
