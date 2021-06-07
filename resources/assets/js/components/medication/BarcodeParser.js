var parseBarcode = (function () {
    'use strict';
    function parseBarcode(barcode) {
        var i = 0, // counter
            fncChar = String.fromCharCode(29), // the ASCII "group separator"
            barcodelength = barcode.length,
            answer = {}, // the object to return
            restOfBarcode = "", // the rest of the barcode, when first 
            // elements are spliced away
            symbologyIdentifier = barcode.slice(0, 3),
            firstElement = {};

        //auxilliary functions

        /**
         * "ParsedElement" is the
         *
         * @constructor for ParsedElements, the components of the array returned by parseBarcode
         * @param {String} elementAI        the AI of the recognized element
         * @param {String} elementDataTitle the title of the element, i.e. its short description
         * @param {String} elementType      a one-letter string describing the type of the element.
         *                                  allowed values are
         *                                  "S" for strings,
         *                                  "N" for numbers and
         *                                  "D" for dates
         */
        function ParsedElement(elementAI, elementDataTitle, elementType) {
            /* defines the object which represents a single element
             */
            this.ai = elementAI; //application identifier
            this.dataTitle = elementDataTitle; //title
            switch (elementType) {
            case "S":
                this.data = ""; // the contents
                break;
            case "N":
                this.data = 0;
                break;
            case "D":
                this.data = new Date();
                this.data.setHours(0, 0, 0, 0);
                break;
            default:
                this.data = "";
                break;
            }
            this.unit = ""; // some elements are accompaigned by an unit of 
            // measurement or currency
        }

        function identifyAI(codestring) {
            // find first identifier. AIs have a minimum length of 2 
            // digits, some have 3, some even 4.
            var firstNumber = codestring.slice(0, 1),
                secondNumber = codestring.slice(1, 2),
                thirdNumber = "",
                fourthNumber = "",
                codestringToReturn = "",
                codestringLength = codestring.length,
                elementToReturn = "";

            function cleanCodestring(stringToClean) {
                // 
                var firstChar = stringToClean.slice(0, 1);
                while (firstChar === fncChar) {
                    stringToClean = stringToClean.slice(1, stringToClean.length);
                    firstChar = stringToClean.slice(0, 1);
                }
                return stringToClean;
            }
            /**
             * Used for calculating numbers which are given as string
             * with a given number of fractional decimals.
             *
             * To avoid conversion errors binary <-> decimal I _don't_
             * just divide by 10 numberOfFractionals times.
             */
            function parseFloatingPoint(stringToParse, numberOfFractionals) {
                var auxString = "",
                    offset = stringToParse.length - numberOfFractionals,
                    auxFloat = 0.0;

                auxString = stringToParse.slice(0, offset) +
                            '.' +
                            stringToParse.slice(offset, stringToParse.length);
                try {
                    auxFloat = parseFloat(auxString);
                } catch (e36) {
                    throw "36";
                }

                return auxFloat;
            }
            /**
             * ======== END of auxiliary function for identifyAI =======
             */

            /**
             *
             * ======== BEGIN of parsing functions in identifyAI =======
             *
             * Some functions to parse the various GS1 formats. They
             * create a new ParsedElement and set its properties.
             *
             * They all modify the variables "elementToReturn" and
             * "codestringToReturn".
             */

            /**
             * dates in GS1-elements have the format "YYMMDD".
             * This function generates a new ParsedElement and tries to fill a
             * JS-date into the "data"-part.
             * @param {String} ai    the AI to use for the ParsedElement
             * @param {String} title the title to use for the ParsedElement
             */
            function parseDate(ai, title) {
                elementToReturn = new ParsedElement(ai, title, "D");
                var offSet = ai.length,
                    dateYYMMDD = codestring.slice(offSet, offSet + 6),
                    yearAsNumber = 0,
                    monthAsNumber = 0,
                    dayAsNumber = 0;

                try {
                    yearAsNumber = parseInt(dateYYMMDD.slice(0, 2), 10);
                } catch (e33) {
                    throw "33";
                }

                try {
                    monthAsNumber = parseInt(dateYYMMDD.slice(2, 4), 10);
                } catch (e34) {
                    throw "34";
                }

                try {
                    dayAsNumber = parseInt(dateYYMMDD.slice(4, 6), 10);
                } catch (e35) {
                    throw "35";
                }
                // we are in the 21st century, but section 7.12 of the specification
                // states that years 51-99 should be considered to belong to the
                // 20th century:
                if (yearAsNumber > 50) {
                    yearAsNumber = yearAsNumber + 1900;
                } else {
                    yearAsNumber = yearAsNumber + 2000;
                }

                if (dayAsNumber > 0) {
                    // Dates in Javascript are funny. Months start at 0. Days, on the other
                    // hand, start at 1. We need to decrement the month by 1. Otherwise, 
                    // the date will be wrong by one month. E.g., month 11 and day 15 
                    // become Dec 15th. If the day is equal to 0, however, we use a Javascript
                    // trick to turn the date into the last day of the previous month. 
                    // So, e.g., month 11 and day 0 become Nov 30th.
                    monthAsNumber--;
                }

                 elementToReturn.data = dateYYMMDD;
                // alert(dateYYMMDD);
                // elementToReturn.data.setFullYear(yearAsNumber, monthAsNumber, dayAsNumber);
                codestringToReturn = codestring.slice(offSet + 6, codestringLength);
            }

            /**
             * simple: the element has a fixed length AND is not followed by an FNC1.
             * @param {String} ai     the AI to use
             * @param {String} title  its title, i.e. its short description
             * @param {Number} length the fixed length
             */
            function parseFixedLength(ai, title, length) {

                elementToReturn = new ParsedElement(ai, title, "S");
                var offSet = ai.length;
                elementToReturn.data = codestring.slice(offSet, length + offSet);
                codestringToReturn = codestring.slice(length + offSet, codestringLength);
            }

            /**
             * tries to parse an element of variable length
             * some fixed length AIs are terminated by FNC1, so this function
             * is used even for fixed length items
             * @param {String} ai    the AI to use
             * @param {String} title its title, i.e. its short description
             */
            function parseVariableLength(ai, title) {
                // 
                elementToReturn = new ParsedElement(ai, title, "S");
                var offSet = ai.length,
                    posOfFNC = codestring.indexOf(fncChar);

                if (posOfFNC === -1) { //we've got the last element of the barcode
                    elementToReturn.data = codestring.slice(offSet, codestringLength);
                    codestringToReturn = "";
                } else {
                    elementToReturn.data = codestring.slice(offSet, posOfFNC);
                    codestringToReturn = codestring.slice(posOfFNC + 1, codestringLength);
                }

            }

            /**
             * the place of the decimal fraction is given by the fourth number, that's
             * the first after the identifier itself.
             *
             * All of theses elements have a length of 6 characters.
             * @param {String} ai_stem      the first digits of the AI, _not_ the fourth digit
             * @param {Number} fourthNumber the 4th number indicating the count of valid fractionals
             * @param {String} title        the title of the AI
             * @param {String} unit         often these elements have an implicit unit of measurement
             */
            function parseFixedLengthMeasure(ai_stem, fourthNumber, title, unit) {
                // 
                elementToReturn = new ParsedElement(ai_stem + fourthNumber, title, "N");
                var offSet = ai_stem.length + 1,
                    numberOfDecimals = parseInt(fourthNumber, 10),
                    numberPart = codestring.slice(offSet, offSet + 6);

                elementToReturn.data = parseFloatingPoint(numberPart, numberOfDecimals);

                elementToReturn.unit = unit;
                codestringToReturn = codestring.slice(offSet + 6, codestringLength);
            }

            /**
             * parses data elements of variable length, which additionally have
             *
             * - an indicator for the number of valid decimals
             * - an implicit unit of measurement
             *
             * These data elements contain e.g. a weight or length.
             *
             */
            function parseVariableLengthMeasure(ai_stem, fourthNumber, title, unit) {
                // the place of the decimal fraction is given by the fourth number, that's
                // the first after the identifier itself.
                elementToReturn = new ParsedElement(ai_stem + fourthNumber, title, "N");
                var offSet = ai_stem.length + 1,
                    posOfFNC = codestring.indexOf(fncChar),
                    numberOfDecimals = parseInt(fourthNumber, 10),
                    numberPart = "";

                if (posOfFNC === -1) {
                    numberPart = codestring.slice(offSet, codestringLength);
                    codestringToReturn = "";
                } else {
                    numberPart = codestring.slice(offSet, posOfFNC);
                    codestringToReturn = codestring.slice(posOfFNC + 1, codestringLength);
                }
                // adjust decimals according to fourthNumber:

                elementToReturn.data = parseFloatingPoint(numberPart, numberOfDecimals);
                elementToReturn.unit = unit;
            }

            /**
             * parses data elements of variable length, which additionally have
             *
             * - an indicator for the number of valid decimals
             * - an explicit unit of measurement
             *
             * These data element contain amounts to pay or prices.
             *
             */
            function parseVariableLengthWithISONumbers(ai_stem, fourthNumber, title) {
                // an element of variable length, representing a number, followed by
                // some ISO-code.
                elementToReturn = new ParsedElement(ai_stem + fourthNumber, title, "N");
                var offSet = ai_stem.length + 1,
                    posOfFNC = codestring.indexOf(fncChar),
                    numberOfDecimals = parseInt(fourthNumber, 10),
                    isoPlusNumbers = "",
                    numberPart = "";

                if (posOfFNC === -1) {
                    isoPlusNumbers = codestring.slice(offSet, codestringLength);
                    codestringToReturn = "";
                } else {
                    isoPlusNumbers = codestring.slice(offSet, posOfFNC);
                    codestringToReturn = codestring.slice(posOfFNC + 1, codestringLength);
                }
                // cut off ISO-Code
                numberPart = isoPlusNumbers.slice(3, isoPlusNumbers.length);
                elementToReturn.data = parseFloatingPoint(numberPart, numberOfDecimals);

                elementToReturn.unit = isoPlusNumbers.slice(0, 3);

            }
            /**
             * parses data elements of variable length, which additionally have
             *
             * - an explicit unit of measurement or reference
             *
             * These data element contain countries, authorities within countries.
             *
             */
            function parseVariableLengthWithISOChars(ai_stem, title) {
                // an element of variable length, representing a sequence of chars, followed by
                // some ISO-code.          
                elementToReturn = new ParsedElement(ai_stem, title, "S");
                var offSet = ai_stem.length,
                    posOfFNC = codestring.indexOf(fncChar),
                    isoPlusNumbers = "";

                if (posOfFNC === -1) {
                    isoPlusNumbers = codestring.slice(offSet, codestringLength);
                    codestringToReturn = "";
                } else {
                    isoPlusNumbers = codestring.slice(offSet, posOfFNC);
                    codestringToReturn = codestring.slice(posOfFNC + 1, codestringLength);
                }
                // cut off ISO-Code
                elementToReturn.data = isoPlusNumbers.slice(3, isoPlusNumbers.length);
                elementToReturn.unit = isoPlusNumbers.slice(0, 3);
            }
            /**
             *
             * ======== END of parsing functions in identifyAI =======
             *
             */
            /**
             *
             * ======= BEGIN of the big switch =======================
             *
             * and now a very big "switch", which tries to find a valid
             * AI within the first digits of the codestring.
             *
             * See the documentation for an explanation why it is made
             * this way (and not by some configuration file).
             */

            switch (firstNumber) {
                case "0":
                    switch (secondNumber) {
                        case "1":
                            // Global Trade Item Number (GTIN)
                            parseFixedLength("01", "GTIN", 14);
                            break;
                        default:
                            throw "01";
                    }
                    break;
                case "1":
                    switch (secondNumber) {
                        case "0":
                            // Batch or Lot Number
                            parseVariableLength("10", "BATCH/LOT");
                            break;
                        case "7":
                            // Expiration Date (YYMMDD)
                            parseDate("17", "EXPIRY");
                            break;
                        default:
                            throw "02";
                    }
                    break;
                case "2":
                    switch (secondNumber) {
                        case "1":
                            // Serial Number
                            parseVariableLength("21", "SERIAL");
                            break;
                    }
            }
            return ({
                element: elementToReturn,
                codestring: cleanCodestring(codestringToReturn)
            });
        }

        /**
         *
         * =========== END of identifyAI =======================
         *
         */

        /**
         * =========== BEGIN of main routine ===================
         */

        /**
         *
         * ==== First step: ====
         *
         * IF there is any symbology identifier
         *   chop it off;
         *   put as "codeName" into the answer;
         *   fill restOfBarcode with the rest
         *   after the symbology identifier;
         * ELSE
         *   leave "codeName" empty;
         *   put the whole barcode into restOfBarcode;
         */

        switch (symbologyIdentifier) {
        case "]C1":
            answer.codeName = "GS1-128";
            restOfBarcode = barcode.slice(3, barcodelength);
            break;
        case "]e0":
            answer.codeName = "GS1 DataBar";
            restOfBarcode = barcode.slice(3, barcodelength);
            break;
        case "]e1":
            answer.codeName = "GS1 Composite";
            restOfBarcode = barcode.slice(3, barcodelength);
            break;
        case "]e2":
            answer.codeName = "GS1 Composite";
            restOfBarcode = barcode.slice(3, barcodelength);
            break;
        case "]d2":
            answer.codeName = "GS1 DataMatrix";
            restOfBarcode = barcode.slice(3, barcodelength);
            break;
        case "]Q3":
            answer.codeName = "GS1 QR Code";
            restOfBarcode = barcode.slice(3, barcodelength);
            break;
        default:
            answer.codeName = "";
            restOfBarcode = barcode;
            break;
        }

        /**
         * we have chopped off any symbology identifier. Now we can
         * try to parse the rest. It should give us an array of
         * ParsedElements.
         */

        /**
         * ===== Second step: ====
         *
         * Parse "barcode" data element by data element using
         * identifyAI.
         *
         */

        answer.parsedCodeItems = [];



        while (restOfBarcode.length > 0) {
            try {
                firstElement = identifyAI(restOfBarcode);
                restOfBarcode = firstElement.codestring;
                answer.parsedCodeItems.push(firstElement.element);
            } catch (e) {
                switch (e) {
                case "01":
                    throw "invalid AI after '0'";
                case "02":
                    throw "invalid AI after '1'";
                case "03":
                    throw "invalid AI after '24'";
                case "04":
                    throw "invalid AI after '25'";
                case "05":
                    throw "invalid AI after '2'";
                case "06":
                    throw "invalid AI after '31'";
                case "07":
                    throw "invalid AI after '32'";
                case "08":
                    throw "invalid AI after '33'";
                case "09":
                    throw "invalid AI after '34'";
                case "10":
                    throw "invalid AI after '35'";
                case "11":
                    throw "invalid AI after '36'";
                case "12":
                    throw "invalid AI after '39'";
                case "13":
                    throw "invalid AI after '3'";
                case "14":
                    throw "invalid AI after '40'";
                case "15":
                    throw "invalid AI after '41'";
                case "16":
                    throw "invalid AI after '42'";
                case "17":
                    throw "invalid AI after '4'";
                case "18":
                    throw "invalid AI after '700'";
                case "19":
                    throw "invalid AI after '70'";
                case "20":
                    throw "invalid AI after '71'";
                case "21":
                    throw "invalid AI after '7'";
                case "22":
                    throw "invalid AI after '800'";
                case "23":
                    throw "invalid AI after '801'";
                case "24":
                    throw "invalid AI after '802'";
                case "25":
                    throw "invalid AI after '80'";
                case "26":
                    throw "invalid AI after '810'";
                case "27":
                    throw "invalid AI after '811'";
                case "28":
                    throw "invalid AI after '81'";
                case "29":
                    throw "invalid AI after '82'";
                case "30":
                    throw "invalid AI after '8'";
                case "31":
                    throw "invalid AI after '9'";
                case "32":
                    throw "no valid AI";
                case "33":
                    throw "invalid year in date";
                case "34":
                    throw "invalid month in date";
                case "35":
                    throw "invalid day in date";
                case "36":
                    throw "invalid number";
                default:
                    throw "unknown error";
                }
            }
        }
        /**
         * ==== Third and last step: =====
         *
         */
        return answer;
    }
    return parseBarcode;
}());
export {parseBarcode}