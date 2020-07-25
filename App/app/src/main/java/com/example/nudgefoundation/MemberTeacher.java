package com.example.nudgefoundation;

public class MemberTeacher {
    String teacher_name;
    String teacher_id;
    String teacher_email;
    String teacher_phone;
    String teacher_password;
    String user_type;
    String user_id;

    public MemberTeacher() {
    }

    public MemberTeacher(String teacher_name, String teacher_id, String teacher_email, String teacher_phone, String teacher_password, String user_type, String user_id) {
        this.teacher_name = teacher_name;
        this.teacher_id = teacher_id;
        this.teacher_email = teacher_email;
        this.teacher_phone = teacher_phone;
        this.teacher_password = teacher_password;
        this.user_type = user_type;
        this.user_id = user_id;
    }

    public String getTeacher_name() {
        return teacher_name;
    }

    public void setTeacher_name(String teacher_name) {
        this.teacher_name = teacher_name;
    }

    public String getTeacher_id() {
        return teacher_id;
    }

    public void setTeacher_id(String teacher_id) {
        this.teacher_id = teacher_id;
    }

    public String getTeacher_email() {
        return teacher_email;
    }

    public void setTeacher_email(String teacher_email) {
        this.teacher_email = teacher_email;
    }

    public String getTeacher_phone() {
        return teacher_phone;
    }

    public void setTeacher_phone(String teacher_phone) {
        this.teacher_phone = teacher_phone;
    }

    public String getTeacher_password() {
        return teacher_password;
    }

    public void setTeacher_password(String teacher_password) {
        this.teacher_password = teacher_password;
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
