document.getElementById('signup-form').addEventListener('submit', function(event){
    event.preventDefault();
    var user_type = document.getElementsByName('user_type')[0].value;
    if(user_type === "") {
      alert("Please select role");
      return false;
    }
    // Implement the rest of the validation or submission logic here
    alert('User added!');
  });
  