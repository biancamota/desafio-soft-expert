import Cookie from "js-cookie";
import api from "@/services/api.js";

export default {
  auth(to, from, next) {
    const token = Cookie.get("_myapp_token");
    const bearer = "Bearer " + token;

    if (!token) {
      next("/");
      return;
    }
    
    verify();

    async function verify() {
      try {
        const { data } = await api.get("/auth/verify", {
          headers: {
            Authorization: bearer,
          },
        });
        next();
      } catch (error) {
        next("/");
        console.log(error.response.data);
      }
    }
  },
};
