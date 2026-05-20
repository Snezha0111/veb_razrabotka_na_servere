const expressionDisplay = document.getElementById("expressionDisplay");
const resultDisplay = document.getElementById("resultDisplay");
let currentExpression = "";

function updateDisplay() {
  expressionDisplay.innerText =
    currentExpression === "" ? "0" : currentExpression;
}

function addToExpression(val) {
  if (val === "!") {
    let match = currentExpression.match(/(\d+(?:\.\d+)?)$/);
    if (match) {
      currentExpression =
        currentExpression.slice(0, -match[0].length) + match[0] + "!";
    } else {
      currentExpression += "!";
    }
  } else if (val === "pi") {
    currentExpression += "pi";
  } else if (val === "e") {
    currentExpression += "e";
  } else {
    currentExpression += val;
  }
  updateDisplay();
}

function backspace() {
  currentExpression = currentExpression.slice(0, -1);
  updateDisplay();
  if (currentExpression === "") {
    expressionDisplay.innerText = "0";
  }
}

function clearDisplay() {
  currentExpression = "";
  expressionDisplay.innerText = "0";
  resultDisplay.innerText = "";
}

function calculateResult() {
  if (!currentExpression.trim()) return;
  window.location.href =
    window.location.pathname + "?expr=" + encodeURIComponent(currentExpression);
}

document.querySelectorAll("button").forEach((btn) => {
  btn.addEventListener("click", () => {
    const val = btn.getAttribute("data-val");
    if (btn.id === "clearBtn") {
      clearDisplay();
    } else if (btn.id === "backspaceBtn") {
      backspace();
    } else if (btn.id === "equalBtn") {
      calculateResult();
    } else if (val) {
      addToExpression(val);
    }
  });
});

document.addEventListener("keydown", (e) => {
  const key = e.key;
  const allowed = ['0','1','2','3','4','5','6','7','8','9','+','-','*','/','.','(',')','^','!','Enter','Backspace','Escape'];
  if (allowed.includes(key)) {
    e.preventDefault();
    if (key === "Enter") {
      calculateResult();
    } else if (key === "Backspace") {
      backspace();
    } else if (key === "Escape") {
      clearDisplay();
    } else {
      addToExpression(key);
    }
  }
});

updateDisplay();
