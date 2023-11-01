function GetSession(VariableName) {
    return new Promise((resolve, reject) => {
      const xhr = new XMLHttpRequest();
      xhr.open('GET', `PHP Modules/SessionVariable.php?VariableName=${VariableName}`);
      xhr.onload = function() {
        if (xhr.status === 200) {
          const sessionVariable = xhr.responseText;
          resolve(sessionVariable);
        } else {
          reject('Error occurred');
        }
      };
      xhr.send();
    });
  }

/*GetSession('yourVariableName')
.then(sessionVariable => {
    console.log('Session Variable:', sessionVariable);
})
.catch(error => {
    console.error('Error:', error);
});*/