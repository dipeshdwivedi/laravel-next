export const API_URL = process.env.NEXT_PUBLIC_BACKEND_URL;
export const TOKEN = "token";
export const USER = "user";


// API ENDPOINTS
export const USER_LOGIN = `/login`;
export const USER_REGISTER = `/register`;
export const USER_LOGOUT = `/logout`;
export const UPLOAD_IMAGE = `/images`;
export const GET_IMAGES = `/images`;
export const GET_IMAGE_VARIANTS = ($id :string) :string => `/images/` + $id;
