<template>
    <b-row>
        <template v-for="i in [0,1,2]">
            <b-col >
                <template v-for="(field,index) in fields"
                          v-if="index < (fields.length/3) * (i+1)
                                                && index >= (fields.length/3) * i">
                    <b-input-group size="sm" class="mb-2" :key="index">
                        <b-col md="4" class="p-0">
                            <b-input-group-prepend>
                                <b-button
                                    size="sm"
                                    :key="index"
                                    :pressed.sync="field.filter.checked"
                                    variant="outline-dark-blue"
                                    block>
                                    {{ field.label }}
                                </b-button>
                            </b-input-group-prepend>
                        </b-col>

                        <b-col md="6" class="p-0">
                            <b-form-input v-if="field.comparator === 'like'"
                                          v-model="field.filter.value"
                                          type="search"
                                          :placeholder="'Enter ' + field.label + ' filter'"
                                          :disabled="!field.filter.checked"
                                          size="sm"
                            ></b-form-input>

                            <vue-slider v-else-if="Array.isArray(field.comparator)"
                                        v-model="field.filter.value"
                                        :min="field.min"
                                        :max="field.max"
                                        :tooltip="'active'"
                                        :disabled="!field.filter.checked"
                                        :process-style="{ backgroundColor: '#684ef9' }"
                                        :tooltip-style="{ backgroundColor: '#684ef9', borderColor: '#684ef9' }"
                                        :enable-cross="false"
                                        class="ml-3"
                            >
                                <template v-slot:dot="{ value, focus }" >
                                    <div :class="['custom-dot', { focus }]"></div>
                                </template>
                            </vue-slider>

                            <el-date-picker
                                v-else-if="field.type === 'date'"
                                v-model='field.filter.value'
                                :disabled="!field.filter.checked"
                                type="date"
                                required
                                placeholder="Pick a Date"
                                format="yyyy/MM/dd"
                                value-format="yyyy-MM-dd"
                                size="mini"
                                class="mr-0">
                            </el-date-picker>


                            <b-input-group-append is-text v-else >
                                <b-form-checkbox v-model="field.filter.value"
                                                 :disabled="!field.filter.checked"
                                                 class="mr-n2 mb-n1 mt-n1"
                                                 size="sm">
                                </b-form-checkbox>
                            </b-input-group-append>
                        </b-col>

                    </b-input-group>
                </template>
            </b-col>
        </template>
    </b-row>
</template>

<script>
    import {
        BButton,
        BButtonGroup,
        BCol,
        BForm,
        BFormCheckbox,
        BFormCheckboxGroup,
        BFormGroup,
        BFormInput,
        BFormSelect,
        BInputGroup,
        BInputGroupAppend,
        BInputGroupPrepend,
        BRow,
    } from "bootstrap-vue";

    import 'vue-slider-component/theme/default.css'
    import VueSlider from "vue-slider-component";

    export default {
        props: ['fields'],
        components: {
            BButton,
            BForm, BFormGroup,
            BFormSelect,
            BFormCheckboxGroup, BFormCheckbox,
            BFormInput, BInputGroup, BInputGroupPrepend, BInputGroupAppend,
            BRow, BCol,
            BButtonGroup,
            VueSlider
        },
    }
</script>

<style scoped>

</style>
