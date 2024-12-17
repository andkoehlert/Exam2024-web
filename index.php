<?php
/*Here is a brief overview of how the router works: 



Get the Request: The script gets the current URL path (e.g., /explore or /login).

Clean the Path: It removes extra slashes and base paths to make the URL easier to compare.

Route Matching: It checks the URL path using a switch statement and matches it to a specific action or file. For example:

/explore maps to loading a controller for posts.
/create_post loads a file for creating a post.
Handle Parameters: Some routes (like /edit_post) look for extra information in the URL (like a post ID) and pass it to the right file.

Authentication: Some pages, like /admin, check if the user is logged in before showing the page.

404 Error: If the path doesn't match any of the cases, it shows a "Page Not Found" error.In sho*/

$request = $_SERVER['REQUEST_URI'];
$usersCrudDir = '/users/';
$usersDir = '/users/views/';
$adminDir = '/admin/views/';
$admincrudDir = '/admin/';

$usersMvcViewsDir = '/users/views/';
$usersMvcModelsDir = '/users/models/';
$usersMvcControllersDir = __DIR__ . '/users/controllers/';

$adminMvcViewsDir = '/admin/views/';
$adminMvcModelsDir = '/admin/models/';
$adminMvcControllersDir = __DIR__ . '/admin/controllers/';




$base_path = ''; 
$request = str_replace($base_path, '', $request);
$request = rtrim($request, '/'); 



$parsedUrl = parse_url($request);
$path = $parsedUrl['path']; 
$query = isset($parsedUrl['query']) ? $parsedUrl['query'] : ''; 

switch ($path) {
    
   

       
            
              case '/create_posts':
            require __DIR__ . $usersMvcViewsDir . 'create_post.php'; 
            break;

            
            case '/explore':
    require $usersMvcControllersDir . 'post_control.php';
    break;
             case '/explore_hot':
                    require $usersMvcControllersDir . 'post_HotControl.php'; 
                    break;
    
        case '':
              case '/explore':
    require $usersMvcControllersDir . 'post_control.php';
    break;
            
          case '/user_home':
            require __DIR__ . $usersMvcViewsDir . 'user_home.php'; 
            break;
            
              case '/user2_home_page':
                require $usersMvcControllersDir . 'postUser_control.php';
                break;
                

            case '/user_home_page':
                require __DIR__ . $usersCrudDir . 'user_home_page.php'; 
                break;
                
                  case '/user_update':
                require $usersMvcControllersDir . 'settingsUserUpdate_controller.php';
                break;

 case '/users':
        require __DIR__ . $adminMvcViewsDir . 'users.php'; 
        break;

       case '/user_settings':
    require $usersMvcControllersDir . 'settingsUser_controller.php';
    break;

    case '/users':
        require __DIR__ . $admincrudDir . 'users.php'; 
        break;

   

    case '/login':
require __DIR__ . $usersCrudDir . 'login.php';
        break;

   
    
    case '/register2':
        require __DIR__ . $usersCrudDir . 'register2.php'; 
        break;

   

case '/manage_pages':
            require __DIR__ . $adminMvcViewsDir . 'manage_pages.php'; 
            break;
   
        
   case '/admin':
    require_once __DIR__ . '/auth.php';
    checkIfLoggedIn();
    require __DIR__ . $admincrudDir . 'index.php';
    break;


    case '/users-create':
        require __DIR__ . $admincrudDir . 'users-create.php'; 
        break;

        case '/logout':  
            require __DIR__ . $usersCrudDir . 'logout.php';
            break;

 
        case '/users-delete':
            
            if (isset($parsedUrl['query'])) {
                parse_str($parsedUrl['query'], $params);
                if (isset($params['id'])) {
                    $_GET['id'] = $params['id']; 
                    require __DIR__ . $admincrudDir . 'users-delete.php'; 
                } else {
                    echo 'User ID is missing';
                }
            } else {
                echo 'No query string provided for user delete.';
            }
            break;

            case '/edit_post':
                
                if (isset($parsedUrl['query'])) {
                    parse_str($parsedUrl['query'], $params);
                    if (isset($params['post_id'])) {
                        $_GET['post_id'] = $params['post_id']; 
                        require __DIR__ . $usersCrudDir  . 'edit_post.php'; 
                    } else {
                        echo 'Post ID is missing';
                    }
                } else {
                    echo 'No query string provided for post edit.';
                }
                break;
            
            case '/delete_post':
                
                if (isset($parsedUrl['query'])) {
                    parse_str($parsedUrl['query'], $params);
                    if (isset($params['post_id'])) {
                        $_GET['post_id'] = $params['post_id']; 
                        require __DIR__ . $usersCrudDir  . 'delete_post.php'; 
                    } else {
                        echo 'Post ID is missing';
                    }
                } else {
                    echo 'No query string provided for post delete.';
                }
                break;
                
                
                
              
                
                      // contact page

                case '/contact':
                    require_once __DIR__ . '/users/controllers/contactController.php';
                
                    $contactController = new ContactController();
                
                    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                        $contactController->showPublic(); 
                    } else {
                        echo json_encode(["success" => false, "error" => "Invalid request method."]);
                    }
                    break;

                
                case '/contact_edit':
                    require_once __DIR__ . '/admin/controllers/contactController.php';
                    $controller = new ContactController();
                    $controller->edit();
                    break;
                
                    case '/update/contact':
                        require_once __DIR__ . '/admin/controllers/contactController.php';
                        require_once __DIR__ . '/auth.php';
                    
                        checkIfLoggedIn('admin'); 
                    
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $contactController = new ContactController();
                            $contactController->update(); 
                        } else {
                            echo json_encode(["success" => false, "error" => "Invalid request method."]);
                        }
                        break;
                    
                

                
                  case '/rules':
                    require_once __DIR__ . '/users/controllers/rulesController.php';
                
                    $rulesController = new RulesController();
                
                    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                        $rulesController->showPublic(); 
                    } else {
                        echo json_encode(["success" => false, "error" => "Invalid request method."]);
                    }
                    break;

                case '/rules':
                    require_once __DIR__ . '/admin/controllers/rulesController.php';
                    $controller = new RulesController();
                    $controller->index();
                    break;
                
                case '/rules_edit':
                    require_once __DIR__ . '/admin/controllers/rulesController.php';
                    $controller = new RulesController();
                    $controller->edit();
                    break;
                
                case '/rules/update':
                    require_once __DIR__ . '/admin/controllers/rulesController.php';
                    $controller = new RulesController();
                    $controller->update();
                    break;
                

                // about page edit

                case '/about':
                    require_once __DIR__ . '/users/controllers/aboutController.php';
                
                    $aboutController = new AboutController();
                
                    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                        $aboutController->showPublic(); 
                    } else {
                        echo json_encode(["success" => false, "error" => "Invalid request method."]);
                    }
                    break;

                case '/about':
                    require_once __DIR__ . '/admin/controllers/aboutController.php';
                    require_once __DIR__ . '/auth.php';
                
                    $aboutController = new AboutController();
                
                   
                    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                        $aboutController->index(); 
                    } else {
                        echo json_encode(["success" => false, "error" => "Invalid request method."]);
                    }
                    break;
                
                case '/about_edit':
                    require_once __DIR__ . '/admin/controllers/aboutController.php';
                    require_once __DIR__ . '/auth.php';
                
                    checkIfLoggedIn('admin'); 
                
                    $aboutController = new AboutController();
                
                    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                        $aboutController->edit(); 
                    } else {
                        echo json_encode(["success" => false, "error" => "Invalid request method."]);
                    }
                    break;
                
                case '/update':
                    require_once __DIR__ . '/admin/controllers/aboutController.php';
                    require_once __DIR__ . '/auth.php';
                
                    checkIfLoggedIn('admin'); 
                
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $aboutController = new AboutController();
                        $aboutController->update(); 
                    } else {
                        echo json_encode(["success" => false, "error" => "Invalid request method."]);
                    }
                    break;
                
                
                
                     case '/posts/on-fire':
                        require_once __DIR__ . '/admin/controllers/onFireController.php';
                        require_once __DIR__ . '/auth.php';
                        require_once __DIR__ . '/config.php'; 
                    
                        checkIfLoggedIn(); 
                    
                        
                        $postController = new PostController($pdo);
                    
                        
                        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                            $postController->showOnFirePosts(); 
                        } else {
                            echo json_encode(["success" => false, "error" => "Invalid request method."]);
                        }
                        break;
                
                
                case '/admin_home':
            // Include necessary files
            require_once __DIR__ . '/admin/controllers/activeUserPostController.php'; 
            require_once __DIR__ . '/auth.php'; 
            
            
            checkIfLoggedIn();
            
            $activeUserPostsController = new ActiveUserPostsController($pdo);
            
            $activeUserPostsController->displayActiveUserPosts(); 
            break;
        
                
        case '/users-edit':
    require_once __DIR__ . '/admin/controllers/editUser_controller.php';
    require_once __DIR__ . '/auth.php';
    checkIfLoggedIn();

    $userId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($userId > 0) {
        $userController = new UserController($pdo);
        $userController->editUserWithPosts($userId);
    } else {
        echo json_encode(["success" => false, "error" => "Invalid user ID."]);
    }
    break;

case '/users/update':
    require_once __DIR__ . '/admin/controllers/editUser_controller.php';
    require_once __DIR__ . '/auth.php';
    checkIfLoggedIn();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userController = new UserController($pdo);
        $userController->updateUser($_POST);
    } else {
        echo json_encode(["success" => false, "error" => "Invalid request method."]);
    }
    break;

case '/users/toggleOnFire':
    require_once __DIR__ . '/admin/controllers/editUser_controller.php';
    require_once __DIR__ . '/auth.php';
    checkIfLoggedIn();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (!isset($_POST['post_id']) || empty($_POST['post_id'])) {
            http_response_code(400); 
            echo json_encode(["success" => false, "error" => "Post ID is required."]);
            exit;
        }

        $postId = (int) $_POST['post_id'];
        $postController = new UserController($pdo);
        $postController->toggleOnFire($postId);
    } else {
        http_response_code(405); 
        echo json_encode(["success" => false, "error" => "Invalid request method. Use POST."]);
        exit;
    }
    break;

                
                
        case '/posts/delete':
    require_once __DIR__ . '/users/controllers/postController.php';
    require_once __DIR__ . '/auth.php';
    checkIfLoggedIn();

    $postId = isset($_POST['post_id']) ? (int)$_POST['post_id'] : 0;

    if ($postId > 0) {
        $postController = new PostController($pdo);
        echo $postController->deletePost($postId);
    } else {
        echo json_encode(["success" => false, "error" => "Invalid post ID."]);
    }
    break;

         case '/posts/submit':
                    require_once __DIR__ . '/users/controllers/createPostController.php';

                    require_once __DIR__ . '/auth.php';
                    checkIfLoggedIn();
                
                    $userId = $_SESSION['users2_id'];
                    $tag = $_POST['tag'] ?? null;
                    $description = $_POST['description'] ?? null;
                    $image = $_FILES['image'] ?? null;
                
                    $postController = new PostController($pdo);
                    $response = $postController->createPost($userId, $tag, $description, $image);
                
                    if ($response['success']) {
                        $_SESSION['status'] = $response['message'];
                        header("Location: /explore");
                    } else {
                        $_SESSION['status'] = $response['error'];
                        header("Location: /create_posts");
                    }
                    exit;

        case '/posts/edit':
                    require_once __DIR__ . '/users/controllers/editPostController.php';
                    require_once __DIR__ . '/auth.php';
                    
                    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                    $uriSegments = explode('/', $uri);
                    // Check if the user is logged in
                    checkIfLoggedIn();
                    
                    
                    $postId = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 0;
                
                    if ($postId > 0) {
                        $postController = new PostController($pdo);
                        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                            echo $postController->editPostForm($postId);
                        }
                        elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            echo $postController->updatePost($postId);
                        }
                    } else {
                        echo json_encode(["success" => false, "error" => "Invalid post ID."]);
                    }
                    break;

case '/comments/delete':
    require_once __DIR__ . '/users/controllers/commentController.php';
    require_once __DIR__ . '/auth.php';
    checkIfLoggedIn();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $commentId = isset($_POST['comment_id']) ? (int)$_POST['comment_id'] : 0;
        
        if ($commentId > 0) {
            $commentController = new CommentController($pdo);
            $response = $commentController->deleteComment($commentId);

            // Check if deletion was successful and redirect
            $data = json_decode($response, true);
            if ($data['success']) {
                // Redirect back to the previous page
                header("Location: " . $_SERVER['HTTP_REFERER'] . "?deleted=true");
                exit;
            } else {
                echo json_encode(["success" => false, "error" => "Error deleting comment."]);
            }
        } else {
            echo json_encode(["success" => false, "error" => "Invalid comment ID."]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "Invalid request method."]);
    }
    break;

            
            

  case '/comments/submit':
        require_once __DIR__ . '/users/controllers/commentController.php';
        require_once __DIR__ . '/auth.php';
    
        checkIfLoggedIn();
    
        $commentController = new CommentController($pdo); 
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $postId = $_POST['post_id'] ?? null; 
            $commentText = $_POST['comment_text'] ?? ''; 
            $commentImage = $_FILES['comment_image'] ?? null; 
    
            if ($postId && $commentText) {
                try {
                    $commentController->submitComment($postId, $commentText, $commentImage);
                } catch (Exception $e) {
                    // Handle exceptions gracefully
                    echo json_encode(["success" => false, "error" => $e->getMessage()]);
                }
            } else {
                // Handle missing data (e.g., missing post ID or text)
                echo json_encode(["success" => false, "error" => "Post ID and comment text are required."]);
            }
        } else {
            // Handle invalid request method (e.g., show an error page)
            echo json_encode(["success" => false, "error" => "Invalid request method."]);
        }
        break;


        case '/like/toggle':
                error_log("Route '/like/toggle' hit");
            
                require_once __DIR__ . '/users/controllers/likeController.php';
                require_once __DIR__ . '/auth.php';
                checkIfLoggedIn();
            
                $userId = $_SESSION['users2_id']; // Logged-in user's ID
                $postId = isset($_GET['post_id']) ? (int)$_GET['post_id'] : 0;
            
                error_log("User ID: " . $userId);
                error_log("Post ID: " . $postId);
            
                // Initialize the controller and toggle like
                $likeController = new LikeController($pdo, $userId);
                
                $likeController->toggleLike($postId);

                break;
            
    default:
        http_response_code(404);
        require __DIR__ . $usersCrudDir . '404.php'; 
        break;
}
