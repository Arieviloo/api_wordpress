<?
function api_usuario_post($request) {
  $nome = sanitize_text_field($request['nome']);
  $email = sanitize_email($request['email']); 
  $senha = sanitize_text_field($request['senha']); 
  // $rua = sanitize_text_field($request['rua']); 
  // $cep = sanitize_text_field($request['cep']); 
  // $numero = sanitize_text_field($request['numero']); 
  // $bairro = sanitize_text_field($request['bairro']); 
  // $cidade = sanitize_text_field($request['cidade']); 
  // $estado = sanitize_text_field($request['estado']); 

  $user_exists = username_exists($email);
  $email_exists = email_exists($email);

  if(!user_exists && !email_exists && $email && $senha){
    $response = array(
      'nome' => $nome,
      'email' => $email,
    );
    wp_create_user($email, $senha, $email);

  }else {
    $response = new WP_Error('email', 'nem sei, só sei que deu nisso', array('status' => 403));
  }

  return rest_ensure_response($response);
}

function registrar_api_usuario_post() {
  register_rest_route('api', '/usuario', array(
    array(
      'methods' => WP_REST_Server::CREATABLE,
      'callback' => 'api_usuario_post'
    ),
  ));
}
add_action('rest_api_init', 'registrar_api_usuario_post');
?>