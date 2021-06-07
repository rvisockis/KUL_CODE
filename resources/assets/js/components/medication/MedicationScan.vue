<template>
    <vue-tabs @tab-change="handleTabChange">
        <v-tab title="Vienetinė pakuotė" name="single">
            <br>
            <div class="form-row">
                <div class="form-group col-md-8">
            <label for="inputlg">Vaisto pakuotės kodas</label>
            <input class="form-control input-lg" id="inputlg" type="text" v-model="data" disabled>
                    <br>
                    <div class="alert" role="alert" v-bind:class="getAlertClass()">
                        {{this.displayText}}
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <input type="radio" name="functionSelection" id="verify" value="verify" v-model="functionSelection">
                    <label for="verify">Verifikacija</label>
                    <br>
                    <input type="radio" name="functionSelection" id="dispense" value="dispense" v-model="functionSelection">
                    <label for="dispense">Išdavimas</label>
                    <br>
                    <input type="radio" name="functionSelection" id="reactivate" value="reactivate" v-model="functionSelection">
                    <label for="reactivate">Grąžinimas į vaistinę</label>
                    <br>
                    <input type="radio" name="functionSelection" id="decommission" value="decommission" v-model="functionSelection">
                    <label for="decommission">Sustabdymas</label>
                </div>
                <div class="form-group col-md-2">
                    <div class="form-group">
                        <select class="form-control" v-model="selectedState" v-if="this.functionSelection==='decommission'">
                            <option disabled value="">Prašome pasirinkti vieną būseną</option>
                            <option value="Exported">Eksportuotas (Exported)</option>
                            <option value="Sample">Pavyzdys (Sample)</option>
                            <option value="Stolen">Pavogtas (Stolen)</option>
                            <option value="Free Sample">Nemokamas pavyzdys (Free Sample)</option>
                            <option value="Locked">Užrakintas (Locked)</option>
                            <option value="Destroyed">Sunaikintas (Destroyed)</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group col-md-8">
            </div>
            <div class="form-group col-md-4" align="center">
                    <p class="scanning-counter">Nuskenuota pakuočių</p>
                    <p class="counter-count">{{counter}}</p>
            </div>


        <!--<div class="alert alert-success" role="alert" v-if="answer === 'OK'">-->
            <!--Viskas gerai, pakuotė sėkmingai verifikuota!!!-->
            <!--{{parsingValue.codeName}}<br />-->
            <!--{{parsingValue.parsedCodeItems[0]}}<br />-->
            <!--{{parsingValue.parsedCodeItems[1]}}<br />-->
            <!--{{parsingValue.parsedCodeItems[2]}}<br />-->
            <!--{{parsingValue.parsedCodeItems[3]}}<br />-->
            <!--&lt;!&ndash;{{parsingValue}}&ndash;&gt;-->
<!--&lt;!&ndash;Viskas gerai, pakuotė sėkmingai verifikuota!!! { "codeName": "", "parsedCodeItems": [ { "ai": "01", "dataTitle": "GTIN", "data": "10080477538142", "unit": "" }, { "ai": "17", "dataTitle": "USE BY OR EXPIRY", "data": "2024-01-22T22:00:00.000Z", "unit": "" }, { "ai": "10", "dataTitle": "BATCH/LOT", "data": "999999", "unit": "" }, { "ai": "21", "dataTitle": "SERIAL", "data": "11JXADIEZU8JSLSURDKI", "unit": "" } ] } { "codeName": "", "parsedCodeItems": [ { "ai": "01", "dataTitle": "GTIN", "data": "10080477538142", "unit": "" }, { "ai": "17", "dataTitle": "USE BY OR EXPIRY", "data": "2024-01-22T22:00:00.000Z", "unit": "" }, { "ai": "10", "dataTitle": "BATCH/LOT", "data": "999999", "unit": "" }, { "ai": "21", "dataTitle": "SERIAL", "data": "11JXADIEZU8JSLSURDKI", "unit": "" } ] }&ndash;&gt;-->
        <!--</div>-->
        <div class="alert alert-danger" role="alert" v-if="answer === 'BAD'">
            Neteisinga kodo struktūra!!! Skenuokite kodą iš naujo!!!
        </div>
            </v-tab>

        <v-tab title="Pakuočių rinkinys" tabName="pack">
            <br>
            <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="inputlg">Vaisto pakuotės kodas</label>
                    <input class="form-control input-lg" id="inputlg" type="text" v-model="data" disabled>
                    <br>
                    <button @click="startScanBulk()" v-show="pushedOrNot === 'NotStarted'">Pradėti</button>
                    <button @click="startScanBulk()" v-show="pushedOrNot === 'Started'">Baigti</button>
                    {{this.startScanPacks}}
                    <br>
                    <br>
                    <div class="alert" role="alert" v-for="information in this.displayFullAnswer" v-bind:class="getAlertClassForBulk(information.result)">
                        {{information.result.information}}
                        <br>
                        <span>Pakelio informacija: </span>{{information.pack}}
                        <br>
                        <span>Operacijos kodas: </span>{{information.result.operationCode}}

                    </div>
                </div>
                <div class="form-group col-md-2">
                    <input type="radio" name="functionSelectionBulk" id="verify" value="verify" v-model="functionSelectionBulk">
                    <label for="verify">Verifikacija</label>
                    <br>
                    <input type="radio" name="functionSelectionBulk" id="dispense" value="dispense" v-model="functionSelectionBulk">
                    <label for="dispense">Išdavimas</label>
                    <br>
                    <input type="radio" name="functionSelectionBulk" id="reactivate" value="reactivate" v-model="functionSelectionBulk">
                    <label for="reactivate">Grąžinimas į vaistinę</label>
                    <br>
                    <input type="radio" name="functionSelectionBulk" id="decommission" value="decommission" v-model="functionSelectionBulk">
                    <label for="decommission">Sustabdymas</label>
                </div>
                <div class="form-group col-md-2">
                    <div class="form-group">
                        <select class="form-control" v-model="selectedState" v-if="this.functionSelectionBulk==='decommission'">
                            <option disabled value="">Prašome pasirinkti vieną būseną</option>
                            <option value="Exported">Eksportuotas (Exported)</option>
                            <option value="Sample">Pavyzdys (Sample)</option>
                            <option value="Stolen">Pavogtas (Stolen)</option>
                            <option value="Free Sample">Nemokamas pavyzdys (Free Sample)</option>
                            <option value="Locked">Užrakintas (Locked)</option>
                            <option value="Destroyed">Sunaikintas (Destroyed)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!--<div class="alert alert-success" role="alert" v-if="answer === 'OK'">-->
            <!--Viskas gerai, pakuotė sėkmingai verifikuota!!!-->
            <!--{{parsingValue.codeName}}<br />-->
            <!--{{parsingValue.parsedCodeItems[0]}}<br />-->
            <!--{{parsingValue.parsedCodeItems[1]}}<br />-->
            <!--{{parsingValue.parsedCodeItems[2]}}<br />-->
            <!--{{parsingValue.parsedCodeItems[3]}}<br />-->
            <!--&lt;!&ndash;{{parsingValue}}&ndash;&gt;-->
            <!--&lt;!&ndash;Viskas gerai, pakuotė sėkmingai verifikuota!!! { "codeName": "", "parsedCodeItems": [ { "ai": "01", "dataTitle": "GTIN", "data": "10080477538142", "unit": "" }, { "ai": "17", "dataTitle": "USE BY OR EXPIRY", "data": "2024-01-22T22:00:00.000Z", "unit": "" }, { "ai": "10", "dataTitle": "BATCH/LOT", "data": "999999", "unit": "" }, { "ai": "21", "dataTitle": "SERIAL", "data": "11JXADIEZU8JSLSURDKI", "unit": "" } ] } { "codeName": "", "parsedCodeItems": [ { "ai": "01", "dataTitle": "GTIN", "data": "10080477538142", "unit": "" }, { "ai": "17", "dataTitle": "USE BY OR EXPIRY", "data": "2024-01-22T22:00:00.000Z", "unit": "" }, { "ai": "10", "dataTitle": "BATCH/LOT", "data": "999999", "unit": "" }, { "ai": "21", "dataTitle": "SERIAL", "data": "11JXADIEZU8JSLSURDKI", "unit": "" } ] }&ndash;&gt;-->
            <!--</div>-->
            <div class="alert alert-danger" role="alert" v-if="answer === 'BAD'">
                Neteisinga kodo struktūra!!! Skenuokite kodą iš naujo!!!
            </div>
            </v-tab>
    </vue-tabs>

</template>
<script>
    import {parseBarcode} from "./BarcodeParser.js"
    function getDefaultData() {
        return {
            data: '',
            counter: 0,
            answer: '',
            parsingValue: '',
            title: 'Vienetinė pakuotė',
            tabIndex: 0,
            //response information
            isAlert: '',
            operationCode: '',
            infoType: '',
            displayText: '',
            displayFullAnswer:'',
            //---------
            //decommission zone
            selectedState: '',
            //------
            //For button text in startup
            startScanPacks: 'Pradėti paketinį skenavimą',
            pushedOrNot: 'NotStarted',
            //--------
            functionSelection: 'dispense',
            //For bulk packs
            functionSelectionBulk: 'verify',
            sourceSingleVerify: '/api/verifySinglePack',
            sourceSingleSupply: '/api/supplySinglePack',
            sourceSingleReactivate: '/api/reactivateSinglePack',
            sourceSingleDecommission: '/api/decommissionSinglePack',
            sourceBulkProcessing: '/api/processingBulkPack',
        }
    }

    export default {
        data(){
            return getDefaultData()
        },
        created() {

            // Add barcode scan listener and pass the callback function
            this.$barcodeScanner.init(this.onBarcodeScanned)
        },
        destroyed() {
            // Remove listener when component is destroyed
            this.$barcodeScanner.destroy()
        },

        mounted() {
            //this.handleTabChange()
            //     let barCodeParser = document.createElement('script')
            //     barCodeParser.setAttribute('src', 'BarcodeParser.js')
            //     document.head.appendChild(barCodeParser)
            //   /  barCodeParser()
        },
        methods: {
            resetData() {
                this.$data = getDefaultData()
            },

            //select class for information success or something different
            getAlertClass(){
                return{
                    'alert-success': this.infoType === 'Information',
                    'alert-danger': (this.isAlert === 'Yes' && this.infoType === 'Warning'),
                    'alert-warning': this.infoType === 'Warning' && this.isAlert !== 'Yes'
                }
            },

            getAlertClassForBulk(integrationIformation) {
                return {
                    'alert-success': integrationIformation.infoType === 'Information',
                    'alert-danger': (integrationIformation.isAlert === 'Yes' && integrationIformation.infoType === 'Warning'),
                    'alert-warning': integrationIformation.infoType === 'Warning' && integrationIformation.isAlert !== 'Yes',
                    'alert-info': integrationIformation.infoType === 'No Information' && integrationIformation.isAlert == 'No Information',
                }
            },
            //select tab name

            handleTabChange(tabIndex, newTab, oldTab) {
                this.tabIndex = tabIndex
                this.infoType = ''
                this.displayText = ''
                this.counter = 0
                this.data = ''
                this.functionSelectionBulk = 'verify'
                this.functionSelection = 'dispense'

                //alert (tabIndex)
                //console.log(tabIndex, newTab.title, oldTab.title)


            },
            //Start scan bulk packs
            startScanBulk(){

                if(this.pushedOrNot === 'NotStarted') {

                    this.startScanPacks =''
                    this.startScanPacks = 'Pabaigti paketinį skenavimą'
                    this.pushedOrNot = 'Started'
                    console.log(this.pushedOrNot)
                    this.packs = []
                    return this.startScanPacks
                }
                else {
                if(this.pushedOrNot  === 'Started'){
                    // alert('keitimas')
                    this.displayFullAnswer = ''
                    this.startScanPacks =''
                    this.startScanPacks = 'Pradėti paketinį skenavimą'
                    this.pushedOrNot = 'NotStarted'
                    switch (this.functionSelectionBulk){
                        case 'verify':
                        var lastOneJson = {
                            "numberOfPacks": this.packs.length,
                            "packs": this.packs
                        }
                        break;
                        case 'dispense':
                            var lastOneJson = {
                                "state": "Supplied",
                                "numberOfPacks": this.packs.length,
                                "packs": this.packs
                            }
                            break;
                        case 'decommission':
                            var lastOneJson = {
                                "state": this.selectedState,
                                "numberOfPacks": this.packs.length,
                                "packs": this.packs
                            }
                            break;
                        case 'reactivate':
                            var lastOneJson = {
                                "state": "Active",
                                "numberOfPacks": this.packs.length,
                                "packs": this.packs
                            }
                            break;
                    }
                    this.resultJson = JSON.stringify(lastOneJson)
                    console.log(this.pushedOrNot)
                    console.log(this.resultJson)
                    //console.log(length(this.packs))
                    if (this.packs.length>0){
                        axios
                            .get(this.sourceBulkProcessing, {
                                params: {
                                     actionName: this.functionSelectionBulk,
                                    // selectedState: this.selectedState ? this.selectedState : "NoSelection",
                                    fullJson: this.resultJson,
                                },
                            })
                            .then(response => {
                                 // console.log(response)
                                if(response.data.statusQuery === 'YES') {
                                    this.isAlert = response.data.data.isalert
                                    this.infoType = response.data.data.infotype
                                    this.operationCode = response.data.data.operationcode
                                    this.displayText = response.data.data.displaytext
                                    this.displayFullAnswer = response.data.responseFull
                                    //console.log(this.displayFullAnswer)
                                    // console.log(this.displayFullAnswer.packs.length)

                                }
                                else{
                                    // alert (response.data.data.operationCode)
                                    this.operationCode = response.data.data.operationCode
                                    this.displayText = response.data.data.warning
                                }
                                // alert(response.data.operationCode)
                            })
                            .catch(error => {
                                console.log(error)
                            })
                    }
                    return this.startScanPacks

                }}
            },
            // Create callback function to receive barcode when the scanner is already done
            onBarcodeScanned(barcode) {
                if (this.tabIndex == 0) {
                    // alert(this.tabIndex)
                    console.log(barcode)
                    this.data = barcode
                    if (this.data == "clearForm") {
                        this.infoType = ''
                        this.displayText = ''
                        this.counter = 0
                        this.data = ''
                    }
                    else {
                        this.parsingValue = parseBarcode(barcode)
                        // console.log(this.parsingValue.parsedCodeItems[0].ai)
                        // alert (this.parsingValue.parsedCodeItems[1].data)
                        if (this.parsingValue.parsedCodeItems == undefined || this.parsingValue.parsedCodeItems.length < 4) {
                            this.answer = 'BAD'
                        }
                        else {
                            // this.answer = 'OK'
                            this.counter++;
                            this.answer = ''
                            // console.log(this.parsingValue)
                            if (this.parsingValue.parsedCodeItems.length == 4) {
                                for (let bluePrintValues of this.parsingValue.parsedCodeItems) {
                                    // console.log(bluePrintValues)
                                    switch (bluePrintValues.ai) {
                                        case '01':
                                            this.gtin = bluePrintValues.data;
                                            break;
                                        case '17':
                                            this.expiryDate = bluePrintValues.data;
                                            break;
                                        case '10':
                                            this.batchId = bluePrintValues.data;
                                            break;
                                        case '21':
                                            this.sn = bluePrintValues.data;
                                            break;
                                    }
                                }
                            }
                            // this.gtin = this.parsingValue.parsedCodeItems[0].data,
                            //     this.sn = this.parsingValue.parsedCodeItems[3].data,
                            // this.batchId = this.parsingValue.parsedCodeItems[1].data,
                            // this.expiryDate = this.parsingValue.parsedCodeItems[2].data
                            //  this.actionName = functionSelection,
                            //   alert(this.functionSelection)
                            switch (this.functionSelection) {
                                case 'verify':
                                    axios
                                        .get(this.sourceSingleVerify, {
                                            params: {
                                                actionName: this.functionSelection,
                                                productCode: this.gtin,
                                                expirityDate: this.expiryDate,
                                                serialNumber: this.sn,
                                                batchNumber: this.batchId,
                                            },
                                        })
                                        .then(response => {
                                            console.log(response)
                                            if (response.data.statusQuery === 'YES') {
                                                this.isAlert = response.data.data.isalert
                                                this.infoType = response.data.data.infotype
                                                this.operationCode = response.data.data.operationcode
                                                this.displayText = response.data.data.displaytext
                                            }
                                            else {
                                                // alert (response.data.data.operationCode)
                                                this.operationCode = response.data.data.operationCode
                                                this.displayText = response.data.data.warning
                                            }
                                            //alert(response.data.operationCode)
                                        })
                                        .catch(error => {
                                            console.log(error)
                                        })
                                    break;
                                case 'dispense':
                                    axios
                                        .get(this.sourceSingleSupply, {
                                            params: {
                                                actionName: this.functionSelection,
                                                productCode: this.gtin,
                                                expirityDate: this.expiryDate,
                                                serialNumber: this.sn,
                                                batchNumber: this.batchId,
                                            },
                                        })
                                        .then(response => {
                                            console.log(response)
                                            if (response.data.statusQuery === 'YES') {
                                                this.isAlert = response.data.data.isalert
                                                this.infoType = response.data.data.infotype
                                                this.operationCode = response.data.data.operationcode
                                                this.displayText = response.data.data.displaytext
                                            }
                                            else {
                                                // alert (response.data.data.operationCode)
                                                this.operationCode = response.data.data.operationCode
                                                this.displayText = response.data.data.warning
                                            }
                                            //alert(response.data.operationCode)
                                        })
                                        .catch(error => {
                                            console.log(error)
                                        })
                                    break;
                                case 'reactivate':
                                    axios
                                        .get(this.sourceSingleReactivate, {
                                            params: {
                                                actionName: this.functionSelection,
                                                productCode: this.gtin,
                                                expirityDate: this.expiryDate,
                                                serialNumber: this.sn,
                                                batchNumber: this.batchId,
                                                // selectedState: this.selectedState,
                                            },
                                        })
                                        .then(response => {
                                            console.log(response)
                                            if (response.data.statusQuery === 'YES') {
                                                this.isAlert = response.data.data.isalert
                                                this.infoType = response.data.data.infotype
                                                this.operationCode = response.data.data.operationcode
                                                this.displayText = response.data.data.displaytext
                                            }
                                            else {
                                                // alert (response.data.data.operationCode)
                                                this.operationCode = response.data.data.operationCode
                                                this.displayText = response.data.data.warning
                                            }
                                            //alert(response.data.operationCode)
                                        })
                                        .catch(error => {
                                            console.log(error)
                                        })
                                    break;
                                case 'decommission':
                                    axios
                                        .get(this.sourceSingleDecommission, {
                                            params: {
                                                actionName: this.functionSelection,
                                                productCode: this.gtin,
                                                expirityDate: this.expiryDate,
                                                serialNumber: this.sn,
                                                batchNumber: this.batchId,
                                                selectedState: this.selectedState,
                                            },
                                        })
                                        .then(response => {
                                            console.log(response)
                                            if (response.data.statusQuery === 'YES') {
                                                this.isAlert = response.data.data.isalert
                                                this.infoType = response.data.data.infotype
                                                this.operationCode = response.data.data.operationcode
                                                this.displayText = response.data.data.displaytext
                                            }
                                            else {
                                                // alert (response.data.data.operationCode)
                                                this.operationCode = response.data.data.operationCode
                                                this.displayText = response.data.data.warning
                                            }
                                            //alert(response.data.operationCode)
                                        })
                                        .catch(error => {
                                            console.log(error)
                                        })
                                    break;
                                default:

                            }
                        }
                    }
                }
                if (this.tabIndex == 1 && this.pushedOrNot=== 'Started') {
                    this.data = barcode
                    this.parsingValue = parseBarcode(barcode)
                    if(this.parsingValue.parsedCodeItems.length == 4){
                        for (let bluePrintValues of this.parsingValue.parsedCodeItems){
                            // console.log(bluePrintValues)
                            switch(bluePrintValues.ai){
                                case '01':
                                    this.gtin = bluePrintValues.data;
                                    break;
                                case '17':
                                    this.expiryDate = bluePrintValues.data;
                                    break;
                                case '10':
                                    this.batchId = bluePrintValues.data;
                                    break;
                                case '21':
                                    this.sn = bluePrintValues.data;
                                    break;
                            }
                        }
                    }
                        // this.gtin = this.parsingValue.parsedCodeItems[0].data,
                        //     this.sn = this.parsingValue.parsedCodeItems[3].data,
                        //     this.batchId = this.parsingValue.parsedCodeItems[2].data,
                        //     this.expiryDate = this.parsingValue.parsedCodeItems[1].data
                    var myScan = {
                        "productCodeScheme": "gs1",
                        "productCode": this.gtin,
                        "serialNumber": this.sn,
                        "batchId": this.batchId,
                        "expiryDate": this.expiryDate
                    }
                    //var myScanToJson = JSON.stringify(myScan)
                    var myScanToJson = myScan
                    this.packs.push(myScanToJson)
                    // console.log(myScanToJson)

            }},
            // Reset to the last barcode before hitting enter (whatever anything in the input box)
            resetBarcode() {
                let barcode = this.$barcodeScanner.getPreviousCode()
                // do something...
            }
    }
    }
</script>

<style scoped>
    .btn span {
        font-size: 1.5em ;
    }

    label input[type="radio"] ~ i.fa.fa-circle-o{
        color: #c8c8c8;    display: inline;
    }
    label input[type="radio"] ~ i.fa.fa-dot-circle-o{
        display: none;
    }
    label input[type="radio"]:checked ~ i.fa.fa-circle-o{
        display: none;
    }
    label input[type="radio"]:checked ~ i.fa.fa-dot-circle-o{
        color: #7AA3CC;    display: inline;
    }
    label:hover input[type="radio"] ~ i.fa {
        color: #7AA3CC;
    }

    /*circle information*/
    .counter
    {
        background-color: #eaecf0;
        text-align: center;
    }
    .employees,.customer,.design,.order
    {
        margin-top: 70px;
        margin-bottom: 70px;
    }
    .counter-count
    {
        font-size: 18px;
        background-color: #00b3e7;
        border-radius: 50%;
        position: relative;
        color: #ffffff;
        text-align: center;
        line-height: 92px;
        width: 92px;
        height: 92px;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
        display: inline-block;
    }

    .scanning-counter
    {
        font-size: 24px;
        color: #000000;
        line-height: 34px;
    }
</style>