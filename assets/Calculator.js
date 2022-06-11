import $ from 'jquery';

class Calculator {
    constructor(prevOperandTextElement, currOperandTextElement) {
        this.prevOperandTextElement = prevOperandTextElement
        this.currOperandTextElement = currOperandTextElement
        this.clear()
    }
    appendNumber(number) {
        if(this.hasError()) return;
        if (number === '.' && this.currOperand.includes('.')) return
        this.currOperand = this.currOperand.toString() + number.toString()
    }
    setOperation(operation) {
        if(this.hasError()) return;
        if (this.currOperand === '') return
        if (this.prevOperand !== '') {
            this.calc(operation);
        } else {
            this.operation = operation;
            this.prevOperand = this.currOperand;
            this.currOperand = '';
        }
    }
    calc(nextOperation = '') {
        if(this.hasError()) return false;
        if(this.prevOperand == '' || this.prevOperand == undefined) return false;

        let that = this;
        $.post('/calc/operation', {
            operation: this.operation,
            val1: parseFloat(this.prevOperand),
            val2: parseFloat(this.currOperand),
        }, function(result){
            console.log(result);

            that.currOperand = parseFloat(result.result);
            that.operation = undefined;
            that.prevOperand = '';

            if(nextOperation != ''){
                that.operation = nextOperation;
                that.prevOperand = that.currOperand;
                that.currOperand = '';
            }

            that.render();

        }).fail(function(result){
            console.log(result);

            that.prevOperandTextElement.innerText = 'Error';
            that.currOperandTextElement.innerText = result.responseJSON.message;
            that.prevOperandTextElement.className = 'previous-operand error';
            that.currOperandTextElement.className = 'current-operand error';
        });
    }
    prepareNumber(number) {
        const stringNumber = number.toString()
        const integerDigits = parseFloat(stringNumber.split('.')[0])
        const decimalDigits = stringNumber.split('.')[1]
        let integerDisplay
        if (isNaN(integerDigits)) {
            integerDisplay = ''
        } else {
            integerDisplay = integerDigits.toLocaleString('en', { maximumFractionDigits: 0 })
        }
        if (decimalDigits != null) {
            return `${integerDisplay}.${decimalDigits}`
        } else {
            return integerDisplay
        }
    }
    render() {
        if(this.hasError()) return;
        this.currOperandTextElement.innerText =
            this.prepareNumber(this.currOperand)
        if (this.operation != null) {
            this.prevOperandTextElement.innerText =
                `${this.prepareNumber(this.prevOperand)} ${this.operation}`
        } else {
            this.prevOperandTextElement.innerText = ''
        }
    }
    hasError() {
        return this.prevOperandTextElement.innerText == 'Error' ? true : false;
    }
    clear() {
        this.currOperand = ''
        this.prevOperand = ''
        this.operation = undefined
        this.prevOperandTextElement.className = 'previous-operand';
        this.currOperandTextElement.className = 'current-operand';
        this.prevOperandTextElement.innerText = '';
    }
    delete() {
        if(this.hasError()) return;
        this.currOperand = this.currOperand.toString().slice(0, -1)
    }
}


const numberButtons = document.querySelectorAll('[data-number]')
const operationButtons = document.querySelectorAll('[data-operation]')
const equalsButton = document.querySelector('[data-equals]')
const deleteButton = document.querySelector('[data-delete]')
const allClearButton = document.querySelector('[data-all-clear]')
const prevOperandTextElement = document.querySelector('[data-previous-operand]')
const currOperandTextElement = document.querySelector('[data-current-operand]')

const calculator = new Calculator(prevOperandTextElement, currOperandTextElement)

numberButtons.forEach(button => {
    button.addEventListener('click', () => {
        calculator.appendNumber(button.innerText)
        calculator.render()
    })
})

operationButtons.forEach(button => {
    button.addEventListener('click', () => {
        calculator.setOperation(button.innerText)
        calculator.render()
    })
})

equalsButton.addEventListener('click', button => {
    calculator.calc()
})

allClearButton.addEventListener('click', button => {
    calculator.clear()
    calculator.render()
})

deleteButton.addEventListener('click', button => {
    calculator.delete()
    calculator.render()
})