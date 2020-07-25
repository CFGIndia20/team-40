const startButton = document.getElementById('start-btn')
const submitButton = document.getElementById('submit-btn')
const nextButton = document.getElementById('next-btn')
const questionContainerElement = document.getElementById('question-container')
const questionElement = document.getElementById('question')
const answerButtonsElement = document.getElementById('answer-buttons')

let shuffledQuestions, currentQuestionIndex
let score = 0
startButton.addEventListener('click', startGame)
nextButton.addEventListener('click', () => {
  currentQuestionIndex++
  setNextQuestion()
})

function startGame() {
  startButton.classList.add('hide')
  shuffledQuestions = questions.sort(() => Math.random() - .5)
  currentQuestionIndex = 0
  questionContainerElement.classList.remove('hide')
  setNextQuestion()
}

function setNextQuestion() {
  resetState()
  showQuestion(shuffledQuestions[currentQuestionIndex])
}

function showQuestion(question) {
  questionElement.innerText = question.question
  question.answers.forEach(answer => {
    const button = document.createElement('button')
    button.innerText = answer.text
    button.classList.add('btn')
    if (answer.correct) {
      button.dataset.correct = answer.correct
    }
    button.addEventListener('click', selectAnswer)
    answerButtonsElement.appendChild(button)
  })
}

function resetState() {
  clearStatusClass(document.body)
  nextButton.classList.add('hide')
  while (answerButtonsElement.firstChild) {
    answerButtonsElement.removeChild(answerButtonsElement.firstChild)
  }
}

function selectAnswer(e) {
  const selectedButton = e.target
  const correct = selectedButton.dataset.correct
  setStatusClass(document.body, correct)
  Array.from(answerButtonsElement.children).forEach(button => {
    setStatusClass(button, button.dataset.correct)
  })
  if (shuffledQuestions.length > currentQuestionIndex + 1) {
    nextButton.classList.remove('hide')
  } else {
    submitButton.classList.remove('hide')
    console.log(score);
  }
}

function setStatusClass(element, correct) {
  clearStatusClass(element)
  if (correct) {
    element.classList.add('correct')
  } else {
    element.classList.add('wrong')
  }
}

function clearStatusClass(element) {
  element.classList.remove('correct')
  element.classList.remove('wrong')
}

const questions = [{
    question: 'What is 2 + 2?',
    answers: [{
        text: '4',
        correct: true
      },
      {
        text: '22',
        correct: false
      }
    ]
  },
  {
    question: 'Communication is a part of ______ skills',
    answers: [{
        text: 'Rough',
        correct: false
      },
      {
        text: 'Soft',
        correct: true
      },
      {
        text: 'Hard',
        correct: false
      },
      {
        text: 'Short',
        correct: false
      }
    ]
  },
  {
    question: 'What is 4 * 2?',
    answers: [{
        text: '6',
        correct: false
      },
      {
        text: '8',
        correct: true
      }
    ]
  },
  {
    question: 'Our dress code is example of _____ skills',
    answers: [{
        text: 'verbal',
        correct: false
      },
      {
        text: 'nonverbal',
        correct: true
      },
      {
        text: 'Writen',
        correct: false
      },
      {
        text: 'Spoken',
        correct: false
      },
    ]
  },
]