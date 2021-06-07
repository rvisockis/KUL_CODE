<template>
    <v-app>
    <v-row class="fill-height">

        <v-col>

            <FullCalendar
                defaultView="timeGridWeek"
                :plugins="calendarPlugins"
                locale="lt"
                firstDay="1"
                :weekends="false"
                :header="calendar_header"
                :footer="calendar_footer"
                :nowIndicator="true"
                :selectable="true"
                :selectMirror="true"
                v-on:select="addEventDialog"
                v-on:eventClick="editEventDialog"
                :events="eventlist"
                :business-hours="eventActiveHours"
                :editable="true"
                v-on:eventDrop="editEventDrop"
                :buttonText="eventButtonText"
                :allDaySlot="false"
            />

            <v-dialog
                v-model="addEvent_dialog"
                max-width="600"
                style="">

                <v-card >
                    <v-card-text>
                    <p style="display: block; font-size: 18px; font-weight: 800; padding-top:16px; word-break: keep-all;">Pridėti operaciją</p>
                    <v-divider></v-divider>
                    <v-text-field label="Nuo" v-model="moment(tempStartDate).locale('lt').format('lll')" disabled></v-text-field>
                    <v-text-field label="Iki" v-model="moment(tempEndDate).locale('lt').format('lll')" disabled></v-text-field>
                        <multiselect v-model="specialistas" label="name"
                                     track-by="name"
                                     placeholder="Įveskite specialisto vardą"
                                     open-direction="bottom"
                                     :options="list" :multiple="true"
                                     :searchable="true"
                                     :internal-search="false"
                                     :clear-on-select="true"
                                     :close-on-select="true"
                                     :options-limit="300" :limit="10"
                                     :max-height="600"
                                     :show-no-results="true"
                                     :show-labels="false"
                                     @search-change="getSpecialistName">
                            <template slot="noOptions"
                                      slot-scope="props">
                                <div>Įrašykite bent 4 pirmas vardo
                                    raides
                                </div>
                            </template>
                            <template slot="noResult"
                                      slot-scope="props">
                                <div>Specialistas nerastas</div>
                            </template>
                        </multiselect>
                    <v-checkbox v-model="pooperacinis_valymas" label="Įtraukti pooperacinį valymą?"></v-checkbox>

                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn
                            color="green darken-1"
                            text
                            @click="addEvent_dialog = false"
                            style="font-size: 14px;"
                        >
                            Atšaukti
                        </v-btn>

                        <v-btn
                            color="green darken-1"
                            text
                            @click="addEvent(tempStartDate, tempEndDate)"
                            style="font-size: 14px;"
                        >
                            Pridėti operaciją
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

                <v-dialog
                    v-model="editEvent_dialog"
                    max-width="600"
                    style="">

                    <v-card >
                        <v-card-text>
                            <p style="display: block; font-size: 18px; font-weight: 800; padding-top:16px; word-break: keep-all;">Redaguoti operacijos įrašą</p>
                            <v-divider></v-divider>
                            <v-text-field v-model="editEvent_title"></v-text-field>
                            <multiselect v-model="specialistas" label="name"
                                         track-by="name"
                                         placeholder="Įveskite specialisto vardą"
                                         open-direction="bottom"
                                         :options="list" :multiple="true"
                                         :searchable="true"
                                         :internal-search="false"
                                         :clear-on-select="true"
                                         :close-on-select="true"
                                         :options-limit="300" :limit="10"
                                         :max-height="600"
                                         :show-no-results="true"
                                         :show-labels="false"
                                         @search-change="getSpecialistName">
                                <template slot="noOptions"
                                          slot-scope="props">
                                    <div>Įrašykite bent 4 pirmas vardo
                                        raides
                                    </div>
                                </template>
                                <template slot="noResult"
                                          slot-scope="props">
                                    <div>Specialistas nerastas</div>
                                </template>
                            </multiselect>
                            <v-checkbox v-model="pooperacinis_valymas" label="Įtraukti pooperacinį valymą?"></v-checkbox>

                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                color="green darken-1"
                                text
                                @click="editEvent_dialog = false"
                                style="font-size: 14px;"
                            >
                                Atšaukti
                            </v-btn>
                            <v-btn
                                color="green darken-1"
                                text
                                @click="removeEvent"
                                style="font-size: 14px;"
                            >
                                Ištrinti
                            </v-btn>

                            <v-btn
                                color="green darken-1"
                                text
                                @click="editEvent"
                                style="font-size: 14px;"
                            >
                                Redaguoti
                            </v-btn>
                        </v-card-actions>
                    </v-card>

            </v-dialog>

<!--            <v-sheet height="64">-->
<!--                <v-toolbar flat color="white">-->
<!--                    <v-btn outlined class="mr-4" @click="setToday">-->
<!--                        Šiandienos planas-->
<!--                    </v-btn>-->
<!--                    <v-btn fab text small @click="prev">-->
<!--                        <v-icon small>mdi-chevron-left</v-icon>-->
<!--                    </v-btn>-->
<!--                    <v-btn fab text small @click="next">-->
<!--                        <v-icon small>mdi-chevron-right</v-icon>-->
<!--                    </v-btn>-->
<!--                    <v-toolbar-title>{{ title }}</v-toolbar-title>-->
<!--                    <div class="flex-grow-1"></div>-->
<!--                    <v-menu bottom right>-->
<!--                        <template v-slot:activator="{ on }">-->
<!--                            <v-btn-->
<!--                                outlined-->
<!--                                v-on="on"-->
<!--                            >-->
<!--                                <span>{{ typeToLabel[type] }}</span>-->
<!--                                <v-icon right>mdi-menu-down</v-icon>-->
<!--                            </v-btn>-->
<!--                        </template>-->
<!--                        <v-list>-->
<!--                            <v-list-item @click="type = 'day'">-->
<!--                                <v-list-item-title>Dienos planas</v-list-item-title>-->
<!--                            </v-list-item>-->
<!--                            <v-list-item @click="type = 'week'">-->
<!--                                <v-list-item-title>Savaitės planas</v-list-item-title>-->
<!--                            </v-list-item>-->
<!--&lt;!&ndash;                            <v-list-item @click="type = 'month'">&ndash;&gt;-->
<!--&lt;!&ndash;                                <v-list-item-title>Month</v-list-item-title>&ndash;&gt;-->
<!--&lt;!&ndash;                            </v-list-item>&ndash;&gt;-->
<!--&lt;!&ndash;                            <v-list-item @click="type = '4day'">&ndash;&gt;-->
<!--&lt;!&ndash;                                <v-list-item-title>4 days</v-list-item-title>&ndash;&gt;-->
<!--&lt;!&ndash;                            </v-list-item>&ndash;&gt;-->
<!--                        </v-list>-->
<!--                    </v-menu>-->
<!--                </v-toolbar>-->
<!--            </v-sheet>-->
<!--            <v-sheet height="1000" style="border-style:">-->
<!--                <v-calendar-->
<!--                    :first-interval="intervals.first"-->
<!--                    :interval-minutes="intervals.minutes"-->
<!--                    :interval-count="intervals.count"-->
<!--                    :interval-height="intervals.height"-->
<!--                    locale="lt"-->
<!--                    ref="calendar"-->
<!--                    v-model="focus"-->
<!--                    :weekdays="weekdays"-->
<!--                    :short-weekdays=false-->
<!--                    color="primary"-->
<!--                    :events="events"-->
<!--                    :event-color="getEventColor"-->
<!--                    :event-margin-bottom="3"-->
<!--                    :now="today"-->
<!--                    :type="type"-->
<!--                    @click:event="showEvent"-->
<!--                    @click:more="viewDay"-->
<!--                    @click:date="viewDay"-->
<!--                    @change="updateRange"-->
<!--                ></v-calendar>-->
<!--                <v-menu-->
<!--                    v-model="selectedOpen"-->
<!--                    :close-on-content-click="false"-->
<!--                    :activator="selectedElement"-->
<!--                    offset-x-->
<!--                >-->
<!--                    <v-card-->
<!--                        color="grey lighten-4"-->
<!--                        min-width="350px"-->
<!--                        flat-->
<!--                    >-->
<!--                        <v-toolbar-->
<!--                            :color="selectedEvent.color"-->
<!--                            dark-->
<!--                        >-->
<!--                            <v-btn icon>-->
<!--                                <v-icon>mdi-pencil</v-icon>-->
<!--                            </v-btn>-->
<!--                            <v-toolbar-title v-html="selectedEvent.name"></v-toolbar-title>-->
<!--                            <div class="flex-grow-1"></div>-->
<!--                            <v-btn icon>-->
<!--                                <v-icon>mdi-heart</v-icon>-->
<!--                            </v-btn>-->
<!--                            <v-btn icon>-->
<!--                                <v-icon>mdi-dots-vertical</v-icon>-->
<!--                            </v-btn>-->
<!--                        </v-toolbar>-->
<!--                        <v-card-text>-->
<!--                            <span v-html="selectedEvent.details"></span>-->
<!--                        </v-card-text>-->
<!--                        <v-card-actions>-->
<!--                            <v-btn-->
<!--                                text-->
<!--                                color="secondary"-->
<!--                                @click="selectedOpen = false"-->
<!--                            >-->
<!--                                Cancel-->
<!--                            </v-btn>-->
<!--                        </v-card-actions>-->
<!--                    </v-card>-->
<!--                </v-menu>-->
<!--            </v-sheet>-->
<!--        </v-col>-->
<!--    </v-row>-->
<!--    <v-row>-->
<!--        <v-col>-->
<!--            <div style="height:20px;"></div>-->
<!--            <div class="col-md-12">-->
<!--                <v-divider></v-divider>-->
<!--                <div class="col-md-6" style="border-style:solid; border-width: 1px;">-->
<!--                    <div class="col-md-12">-->
<!--                    <label class="col-md-1" style="margin-left:-20px;margin-top: 15px;">Data</label>-->
<!--                    <v-menu-->
<!--                        ref="menu"-->
<!--                        v-model="datepicker_menu"-->
<!--                        :close-on-content-click="false"-->
<!--                        transition="scale-transition"-->
<!--                        offset-y-->
<!--                        min-width="290px"-->

<!--                    >-->
<!--                        <template v-slot:activator="{ on }">-->
<!--                            <v-text-field-->
<!--                                v-model="datepicker_data"-->
<!--                                class="col-md-4"-->
<!--                                label=""-->
<!--                                readonly-->
<!--                                v-on="on"-->
<!--                            ></v-text-field>-->
<!--                        </template>-->
<!--                        <v-date-picker v-model="datepicker_data" no-title  locale="lt" @input="datepicker_menu = false">-->
<!--                        </v-date-picker>-->
<!--                    </v-menu>-->
<!--                </div>-->
<!--                <label class="col-md-3">Operacijos pradžia: </label>-->
<!--                <a-time-picker v-model="operacijos_pradzia" class="col-md-3" format="HH:mm" value="" />-->
<!--                <label class="col-md-3">Operacijos pabaiga: </label>-->
<!--                <a-time-picker v-model="operacijos_pabaiga" class="col-md-3" format="HH:mm" value="" />-->
<!--                <div class="col-md-12" style="margin-left:-15px;">-->
<!--                    <label-->
<!--                        class="col-md-2 col-form-label">Specialistas</label>-->
<!--                    &lt;!&ndash; no database entries for names by SP for all specialistas models  &ndash;&gt;-->
<!--                    <div class="col-md-10">-->
<!--                        <multiselect v-model="specialistas" label="name"-->
<!--                                     track-by="name"-->
<!--                                     placeholder="Įveskite specialisto vardą"-->
<!--                                     open-direction="bottom"-->
<!--                                     :options="list" :multiple="true"-->
<!--                                     :searchable="true"-->
<!--                                     :internal-search="false"-->
<!--                                     :clear-on-select="true"-->
<!--                                     :close-on-select="true"-->
<!--                                     :options-limit="300" :limit="10"-->
<!--                                     :max-height="600"-->
<!--                                     :show-no-results="true"-->
<!--                                     :show-labels="false"-->
<!--                                     @search-change="getSpecialistName">-->
<!--                            <template slot="noOptions"-->
<!--                                      slot-scope="props">-->
<!--                                <div>Įrašykite bent 4 pirmas vardo-->
<!--                                    raides-->
<!--                                </div>-->
<!--                            </template>-->
<!--                            <template slot="noResult"-->
<!--                                      slot-scope="props">-->
<!--                                <div>Specialistas nerastas</div>-->
<!--                            </template>-->
<!--                        </multiselect>-->
<!--                    </div>-->

<!--                    <div class="form-group row">-->
<!--                        <label class="col-sm-2 col-form-label">Ligos-->
<!--                            kodas</label>-->
<!--                        <div class="col-sm-10">-->
<!--                            &lt;!&ndash;                                                                        HIS ID: {{this.FullInfo.HIS_ID}}&ndash;&gt;-->
<!--                            <multiselect v-model="diagnoze"-->
<!--                                         track-by="title"-->
<!--                                         placeholder="Įveskite tris simbolius"-->
<!--                                         open-direction="bottom"-->
<!--                                         :options="diagnosis_list"-->
<!--                                         :searchable="true"-->
<!--                                         :internal-search="false"-->
<!--                                         :clear-on-select="true"-->
<!--                                         :close-on-select="true"-->
<!--                                         :options-limit="300" :limit="10"-->
<!--                                         :max-height="600"-->
<!--                                         :show-no-results="true"-->
<!--                                         :show-labels="false"-->
<!--                                         @search-change="GetList">-->
<!--                                <template slot="option" slot-scope="props">-->
<!--                                    <div class="option__desc"><span-->
<!--                                        class="option__small">{{ props.option.code}} - {{ props.option.title}}</span>-->
<!--                                    </div>-->
<!--                                </template>-->
<!--                                <template slot="noOptions"-->
<!--                                          slot-scope="props">-->
<!--                                    <div>Įrašykite bent 3 simbolius-->
<!--                                    </div>-->
<!--                                </template>-->
<!--                                <template slot="singleLabel" slot-scope="props">-->
<!--                                    <div v-model="pavadinimas">{{props.option.code}} - {{props.option.title}}</div>-->
<!--                                </template>-->
<!--                                <template slot="noResult"-->
<!--                                          slot-scope="props">-->
<!--                                    <div>Ligos kodas nerastas</div>-->
<!--                                </template>-->
<!--                            </multiselect>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <v-textarea-->
<!--                        v-model="komentarai"-->
<!--                        name="input-7-4"-->
<!--                        label="Komentaras"-->
<!--                        value=""-->
<!--                    ></v-textarea>-->

<!--                    <div class="col-md-2">-->
<!--                        <v-btn style="margin-top:15px;" large color="primary" @click="saveEvent">Išsaugoti</v-btn>-->
<!--                    </div>-->
<!--                    <v-checkbox-->
<!--                        v-model="valymas"-->
<!--                        :label="`Įtraukti pooperacinį valymą`"-->
<!--                        class="col-md-4"-->
<!--                    ></v-checkbox>-->
<!--                </div>-->


<!--                </div>-->
<!--                <div class="col-md-12" style="margin-bottom:1500px;"></div>-->
<!--                <div class="col-md-3">-->
<!--                    <h3>Recursive</h3>-->
<!--                    <v-text-field class="col-md-12" v-model="fabinacci_recursive" solo>-->
<!--                    </v-text-field>-->
<!--                    <v-btn @click="testFunction(fabinacci_recursive)" class="col-md-12" style="margin-bottom:15px;">get the answer</v-btn>-->
<!--                    <v-text-field class="col-md-12" v-model="fabinacci_recursive_answer" solo>-->
<!--                    </v-text-field>-->
<!--                    <v-text-field class="col-md-12" v-model="fabinacci_recursive_time" solo suffix="seconds to get the answer">-->
<!--                    </v-text-field>-->
<!--                    <v-divider></v-divider>-->
<!--                </div>-->
<!--                <div class="col-md-3">-->
<!--                    <h3>Linear</h3>-->
<!--                    <v-text-field class="col-md-12" v-model="fibonacci_linear" solo>-->
<!--                    </v-text-field>-->
<!--                    <v-btn @click="getFibonacciLinear(fibonacci_linear)" class="col-md-12" style="margin-bottom:15px;">get the answer</v-btn>-->
<!--                    <v-text-field class="col-md-12" v-model="fibonacci_linear_answer" solo>-->
<!--                    </v-text-field>-->
<!--                    <v-text-field class="col-md-12" v-model="fibonacci_linear_time" solo suffix="seconds to get the answer">-->
<!--                    </v-text-field>-->
<!--                    <v-divider></v-divider>-->
<!--                </div>-->

<!--                <div class="col-md-12">-->
<!--                </div>-->
<!--                <div class="col-md-3">-->
<!--                    <v-btn @click="kruskalSort(kruskal_graph)" class="col-md-12" style="margin-bottom:15px;">1. Surikiuojame briaunas pagal svorį</v-btn>-->
<!--                </div>-->
<!--                <div class="col-md-3"><code>{{JSON.stringify(kruskal_graph)}}</code></div>-->



<!--            </div>-->

        </v-col>
    </v-row>
    </v-app>
</template>

<script>
    import moment from 'moment'
    import dayGridPlugin from '@fullcalendar/daygrid'
    import timeGridPlugin from '@fullcalendar/timegrid'
    import interactionPlugin from '@fullcalendar/interaction'
    export default {
        name: "Kalendorius",
        data: () => ({
            eventButtonText: {
                today: 'Šiandien',
                month: 'Mėnuo',
                week: 'Savaitės kalendorius',
                day: 'Dienos kalendorius',
                list: 'Sąrašas'
            },
            tempEventInfo: [],
            pooperacinis_valymas: false,
            eventlist: [],
            eventActiveHours: {
                startTime: '08:00',
                endTime: '18:00'
            },
            editEvent_title: '',
            tempStartDate: Date(),
            tempEndDate: Date(),
            addEvent_dialog: false,
            editEvent_dialog: false,
            clientip: '',
            calendarPlugins: [ timeGridPlugin, interactionPlugin, dayGridPlugin],
            calendar_header: {left: 'today prev,next', center: 'timeGridDay,timeGridWeek', right: 'title'},
            calendar_footer: {left: 'today prev,next', center: '', right: ''},
            today: '',
            focus: '',
            type: 'week',
            typeToLabel: {
                month: 'Month',
                week: 'Savaitės planas',
                day: 'Dienos planas',
                '4day': '4 Days',
            },
            start: null,
            end: null,
            selectedEvent: {},
            intervals: {
                first: 7,
                minutes: 60,
                count: 11,
                height: 80
            },
            selectedElement: null,
            selectedOpen: false,
            datepicker_menu: false,
            datepicker_data: '',
            specialistas: [],
            list: [],
            fakelist: [],
            diagnosis_list: [],
            diagnoze: [],
            valymas: false,
            pavadinimas: [],
            operacijos_pradzia: '',
            operacijos_pabaiga: '',
            Today: '',
            komentarai: '',
            spalvos: ['blue','indigo','deep-purple','cyan','red','brown','deep-orange','teal','green'],
            events: [],
            fabinacci_recursive: 0,
            fabinacci_recursive_answer: 0,
            fabinacci_recursive_time: 0,
            fibonacci_linear:0,
            fibonacci_linear_answer:0,
            fibonacci_linear_time:0,
            parent: [],
            kruskal_graph: [
                { weight: 4, src: 0, dest: 1},
                { weight: 10, src: 5, dest: 4},
                { weight: 11, src: 1, dest: 7},
                { weight: 8, src: 0, dest: 7},
                { weight: 8, src: 1, dest: 2},
                { weight: 1, src: 7, dest: 6},
                { weight: 2, src: 8, dest: 2},
                { weight: 2, src: 6, dest: 5},
                { weight: 9, src: 3, dest: 4},
                { weight: 4, src: 2, dest: 5},
                { weight: 6, src: 8, dest: 6},
                { weight: 7, src: 2, dest: 3},
                { weight: 7, src: 7, dest: 8},
                { weight: 14, src: 3, dest: 5},
            ],
            briaunu_sk: 8,

            weekdays: [1,2,3,4,5,6,0],
        }),
        computed: {
            title () {
                const { start, end } = this
                if (!start || !end) {
                    return ''
                }

                const startMonth = this.monthFormatter(start)
                const endMonth = this.monthFormatter(end)
                const suffixMonth = startMonth === endMonth ? '' : endMonth

                const startYear = start.year
                const endYear = end.year
                const suffixYear = startYear === endYear ? '' : endYear

                const startDay = start.day + this.nth(start.day)
                const endDay = end.day + this.nth(end.day)

                switch (this.type) {
                    case 'month':
                        return `${startMonth} ${startYear}`
                    case 'week':
                    case '4day':
                        return `${startMonth} ${startDay} ${startYear} - ${suffixMonth} ${endDay} ${suffixYear}`
                    case 'day':
                        return `${startMonth} ${startDay} ${startYear}`
                }
                return ''
            },
            monthFormatter () {
                return this.$refs.calendar.getFormatter({
                    timeZone: 'UTC', month: 'long',
                })
            },
        },
        methods: {


            editEventDrop(eventDropInfo){
                let index;
                console.log(eventDropInfo.event)
                for(let a = 0; a < this.eventlist.length; a++){
                    if(this.eventlist[a].id == eventDropInfo.event.id){
                        index = a
                    }
                }
                this.eventlist[index].start = eventDropInfo.event.start
                this.eventlist[index].end = eventDropInfo.event.end

            },

            addEventDialog(selectionInfo){
                this.addEvent_dialog = true;
                this.tempStartDate = moment(selectionInfo.start).locale('lt').format('')
                this.tempEndDate =  moment(selectionInfo.end).locale('lt').format('')
            },

            editEventDialog(eventInfo){
                this.tempEventInfo = eventInfo
                this.editEvent_dialog = true;
                this.editEvent_title = eventInfo.event.title

            },

            editEvent(){
                let index;
                for(let masyvo_indeksas = 0; masyvo_indeksas < this.eventlist.length; a++){
                    if(this.eventlist[masyvo_indeksas].id == this.tempEventInfo.event.id){
                        index = masyvo_indeksas
                    }
                }
                console.log(index)
                this.eventlist[index].title = this.editEvent_title
                this.editEvent_dialog = false;
                this.tempEventInfo = [];
            },

            removeEvent(){
                let index;
                for(let a = 0; a < this.eventlist.length; a++){
                    if(this.eventlist[a].id == this.tempEventInfo.event.id){
                        index = a
                    }
                }
                console.log(index)
                this.eventlist.splice(index, 1);
                this.editEvent_dialog = false;
                this.tempEventInfo = [];
            },

            addEvent(start, end){
                let color = this.spalvos[Math.floor(Math.random()*this.spalvos.length)]
                if(!this.pooperacinis_valymas) {
                    this.eventlist.push({
                        id: this.eventlist.length,
                        title: 'random title for now',
                        start: start,
                        end: end,
                        allDay: false,
                        backgroundColor: color,
                        textColor: 'white',
                        borderColor: 'black',

                    })
                    this.addEvent_dialog = false
                } else {
                    let end_pooperacinis = moment(end).add(30, 'minutes').format()
                    console.log('pooperacinio pradzia' + end)
                    console.log('pooperacinio pabaiga' + end_pooperacinis)

                    this.eventlist.push({
                        title: 'Random title for now + pooperacinis valymas',
                        start: start,
                        end: end,
                        allDay: false,
                        backgroundColor: color,
                        textColor: 'white',
                        borderColor: 'black'
                    })

                    this.eventlist.push({
                        title: 'Pooperacinis valymas',
                        start: end,
                        end: end_pooperacinis,
                        allDay: false,
                        backgroundColor: 'black',
                        textColor: 'white',
                        borderColor: 'white'
                    })

                    this.addEvent_dialog = false
                    this.pooperacinis_valymas = false
                }

            },

            viewDay ({ date }) {
                this.focus = date
                this.type = 'day'
            },
            moment,
            saveEvent() {
                var url_post = '/api/getOperacijuPlanas'

                var event_begins_time = this.getFormattedTime(this.operacijos_pradzia)
                var event_ends_time = this.getFormattedTime(this.operacijos_pabaiga)
                var event_name = 'Operacija - ' + this.specialistas[0].name
                var event_details = 'Specialistas: ' + this.specialistas[0].name + '. Operacijos pradžia: ' +
                    this.datepicker_data + ' ' + event_begins_time + '. Ligos kodas: ' + this.diagnoze.code +
                    '. Papildomi komentarai: ' + this.komentarai;
                var event_begins = this.datepicker_data + ' ' + event_begins_time;
                var event_ends = this.datepicker_data + ' ' + event_ends_time;
                var color = this.spalvos[Math.floor(Math.random()*this.spalvos.length)]

                this.events.push({
                    name: event_name,
                    details: event_details,
                    start: event_begins,
                    end: event_ends,
                    color: color,
                    day: this.datepicker_data
                })

                axios.post(url_post, {

                    name: event_name,
                    details: event_details,
                    start: event_begins,
                    end: event_ends,
                    color: color,
                    day: this.datepicker_data

                })

                if(this.valymas){
                    var valymas_begins_time = this.getFormattedTime(this.operacijos_pabaiga)
                    var valymas_ends_time = this.getValymasTime(this.operacijos_pabaiga)
                    var valymas_name = 'Valymas'
                    var valymas_details = 'Pooperacinis valymas'
                    var valymas_begins = this.datepicker_data + ' ' + valymas_begins_time;
                    var valymas_ends = this.datepicker_data + ' ' + valymas_ends_time;
                    var valymas_color = 'black';
                    this.events.push({
                        name: valymas_name,
                        details: valymas_details,
                        start: valymas_begins,
                        end: valymas_ends,
                        color: valymas_color,
                        day: this.datepicker_data
                    })
                    this.valymas = false;
                }


            },






            testFunction(number){
                var t0 = performance.now();
                this.fabinacci_recursive_answer = this.getFibonacciRecursive(number);
                var t1 = performance.now();
                this.fabinacci_recursive_time = ((t1 - t0)/1000).toFixed(3);
            },

            getFibonacciRecursive(number) {
                console.log('current number: ' + number)
                if (number && number < 2) {
                    return 1;
                }
                if(number === 0) {
                    return 0;
                }
                return this.getFibonacciRecursive(number - 1) + this.getFibonacciRecursive(number - 2)
            },

            getFibonacciLinear(number) {
                var t0 = performance.now();
                let fibonacci = [1,1]

                for(let i = 2; i <= number; i++){
                    fibonacci[i] = fibonacci[i-1] + fibonacci[i-2];

                }
                console.log(fibonacci)
                this.fibonacci_linear_answer = fibonacci[number-1]
                var t1 = performance.now();
                this.fibonacci_linear_time = ((t1 - t0)/1000).toFixed(5);
            },

            // kruskal(array){
            //     let mincost = 0;
            //     for (let i = 0; i < this.briaunu_sk; i++) {
            //         this.parent[i] = i;
            //     }
            //     for(let briaunu_sk = 0; briaunu_sk < this.briaunu_sk; briaunu_sk++) {
            //         let a = 0;
            //         let b = 0;
            //         let min;
            //
            //         for(let x = 0; x < this.briaunu_sk; x++){
            //             for(let y = 0; y < this.briaunu_sk; y++){
            //                 if(this.find(x) != this.find(y) && )
            //             }
            //         }
            //     }
            // },

            kruskalSort(array){
                array.sort((a, b) => (a.weight > b.weight) ? 1 : -1);
                console.log(array)
            },









            getFormattedTime(x) {
                var today = x;
                today = moment(today).format('HH:mm')
                return today;
            },
            getValymasTime(x) {
                var today = x;
                today = moment(today).add(30, 'm')
                today = moment(today).format('HH:mm')
                return today;
            },

            getToday(){
              var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
                var yyyy = today.getFullYear();

              today = yyyy + '-' + mm + '-' + dd;
              this.today = today;
              this.focus = today;
              console.log('today: ' + this.today)
            },
            //Gets available diagnosis from database
            GetList(query) {
                this.diagnosis_list = [];
                axios.get('/api/getDiagnosisList', {params: {CODE: query}})
                    .then(response => {
                        this.diagnosis_fakelist = response.data;
                        for (var a = 0; a < this.diagnosis_fakelist.length; a++) {
                            this.diagnosis_list.push({
                                "name": this.diagnosis_fakelist[a].CODE,
                                "code": this.diagnosis_fakelist[a].CODE,
                                "title": this.diagnosis_fakelist[a].TITLE
                            });
                        }
                        this.isdiagnosis_list = true;
                        return this.diagnosis_list;

                    })
                    .catch(error => {
                        console.log(error)
                    });
            },
            getSpecialistName(query) {
                this.list = [];
                if (query.length > 3)
                    axios.get('/api/getSpecialistName', {params: {display_name: query}})
                        .then(response => {
                            this.fakelist = response.data;
                            for (var a = 0; a < this.fakelist.length; a++) {
                                this.list.push({
                                    "name": this.fakelist[a].display_name

                                });
                            }
                            this.islist = true;
                            return this.list;

                        })
                        .catch(error => {
                            console.log(error)
                        });

            },
            getEventColor (event) {
                return event.color
            },
            setToday () {
                this.focus = this.today;
                this.type = 'day';
            },
            prev () {
                this.$refs.calendar.prev()
            },
            next () {
                this.$refs.calendar.next()
            },
            showEvent ({ nativeEvent, event }) {
                const open = () => {
                    this.selectedEvent = event
                    this.selectedElement = nativeEvent.target
                    setTimeout(() => this.selectedOpen = true, 10)
                }

                if (this.selectedOpen) {
                    this.selectedOpen = false
                    setTimeout(open, 10)
                } else {
                    open()
                }

                nativeEvent.stopPropagation()
            },
            updateRange ({ start, end }) {
                // You could load events from an outside source (like database) now that we have the start and end dates on the calendar
                this.start = start
                this.end = end
            },
            nth (d) {
                return d > 3 && d < 21
                    ? 'th'
                    : ['th', 'st', 'nd', 'rd', 'th', 'th', 'th', 'th', 'th', 'th'][d % 10]
            },
        },
        beforeMount() {
            this.getToday();
            // this.getClientIP()
        }
    }
</script>

<style scoped>

    >>> .v-dialog:not(.v-dialog--fulscreen) {
        margin-top:0px !important;
    }

   >>> .fc-icon {
        margin-top:-12px;
    }

</style>
