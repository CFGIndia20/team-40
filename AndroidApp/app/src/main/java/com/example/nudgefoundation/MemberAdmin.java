package com.example.nudgefoundation;

public class MemberAdmin {
    String admin_name;
    String admin_id;
    String admin_email;
    String admin_phone;
    String admin_password;
    String user_type;
    String user_id;

    public MemberAdmin() {
    }

    public MemberAdmin(String admin_name, String admin_id, String admin_email, String admin_phone, String admin_password, String user_type, String user_id) {
        this.admin_name = admin_name;
        this.admin_id = admin_id;
        this.admin_email = admin_email;
        this.admin_phone = admin_phone;
        this.admin_password = admin_password;
        this.user_type = user_type;
        this.user_id = user_id;
    }

    public String getAdmin_name() {
        return admin_name;
    }

    public void setAdmin_name(String admin_name) {
        this.admin_name = admin_name;
    }

    public String getAdmin_id() {
        return admin_id;
    }

    public void setAdmin_id(String admin_id) {
        this.admin_id = admin_id;
    }

    public String getAdmin_email() {
        return admin_email;
    }

    public void setAdmin_email(String admin_email) {
        this.admin_email = admin_email;
    }

    public String getAdmin_phone() {
        return admin_phone;
    }

    public void setAdmin_phone(String admin_phone) {
        this.admin_phone = admin_phone;
    }

    public String getAdmin_password() {
        return admin_password;
    }

    public void setAdmin_password(String admin_password) {
        this.admin_password = admin_password;
    }

    public String getUser_type() {
        return user_type;
    }

    public void setUser_type(String user_type) {
        this.user_type = user_type;
    }

    public String getUser_id() {
        return user_id;
    }

    public void setUser_id(String user_id) {
        this.user_id = user_id;
    }
}
