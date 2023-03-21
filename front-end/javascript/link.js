const link_pages = {};
link_pages.base_url = "http://127.0.0.1:8000/api/";

link_pages.getApi = async (api_url) => {
  try {
    return await axios(api_url);
  }
  catch (error) {
    console.log("Error from GET API");
  }
}

link_pages.postAPI = async (api_url, api_data, api_token = null) => {
  try {
    return await axios.post(
      api_url,
      api_data,
      {
        headers: {
          'Authorization': "token " + api_token
        }
      }
    );
  } catch (error) {
    console.log("Error from POST API");
  }
}

link_pages.loadFor = (page) => {
  eval("link_pages.load_" + page + "();");
}




link_pages.load_login = async () => {
  const mess = document.getElementById('resp');
  let uEmail = document.getElementById("email").value;
  let uPassword = document.getElementById("password").value;
  let data = new FormData();
  data.append('email', uEmail);
  data.append('password', uPassword);
  const login_url = link_pages.base_url + "login";
  const response = await link_pages.postAPI(login_url, data);
  const login = response.data;
  localStorage.setItem('user', JSON.stringify(res.data.user));
  localStorage.setItem('token', res.data.authorisation.token);

  if (login.status == "error") {
    mess.textContent = "Email Not Found";
  }

  else if (login.status == "success") {
    window.location.href="user.html"
  }
}


link_pages.load_signup = async () => {
  const data = new FormData();
  const uName = document.getElementById("user_name");
  const uEmail = document.getElementById("user_email");
  const uPassword = document.getElementById("user_password");
  const uGender = document.getElementById("gender");
  const uAge = document.getElementById("user_age");
  const uCity = document.getElementById("city");
  const uPic = document.getElementById("user_pic");
  data.append("Name", uName.value);
  data.append("Email", uEmail.value);
  data.append("Password", uPassword.value);
  data.append("Dob", uGender.value);
  data.append("Usertype_id", uAge.value);
  data.append("Usertype_id", uCity.value);
  data.append("Usertype_id", uPic.value);
  const signup_url = link_pages.base_url + "signup";
  const response = await link_pages.postAPI(signup_url, data);
  const signup = response.data;
  if (login.status == "error") {
    mess.textContent = "Email Not Found";
  }

  else if (login.status == "success") {
    window.location.href="user.html"
  }
}





