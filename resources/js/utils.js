async function request(
  url, 
  onSuccess,  
  data, 
  type,
  button = null, 
  headers = {}
){
  const options = {
    method: 'POST',
    body: null,
    headers: {}
  }

  try {
    const response = await fetch(url, {...options, body: data, headers: headers});

    if(!response.ok){
      return
    }
    
    const responseData = await response.json();

    if(button !== null)
      disabled(button, 'enabled');

    if(type === "auth" && responseData.type === "success"){
      location.href = SYSTEM_URL + responseData.message;
      return
    }

    if(type === "fetch" && responseData.type === "success"){
      onSuccess(responseData.message);
      return
    }
    
    toast(responseData.message, responseData.type);

    if(responseData.type === "success"){
      onSuccess();
    }
    
    // const responseData = await response.text();
    // console.log(responseData);
  } catch (error) {
    toast(error, 'error');
  }
}