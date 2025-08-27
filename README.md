# Admin & Member Pack (Laravel 8+)

This is a drop-in feature pack implementing:

- Admin registration + email verification (`/admin/register`)
- Admin login/logout (`/admin/login`), blocking unverified
- Admin manage Admins (list/search/create/edit/CSV) (`/admin/member...`)
- Admin manage Members (list/search/create/edit/CSV) (`/admin/customer...`)
- Front (Member) login/logout (`/login`), blocking unverified
- Front member registration + email verification (`/entry`)
- My Page edit for member (`/mypage/edit`)

## Install

1. Clone this repo https://github.com/tahsinasuchi/test-app-email-verification-.git

2. Run migrations:
   ```bash
   php artisan migrate
   ```

3. Configure mail (for email verification) in `.env`:
   ```env
    MAIL_MAILER=
    MAIL_HOST=
    MAIL_PORT=
    MAIL_USERNAME=
    MAIL_PASSWORD=
    MAIL_ENCRYPTION=
    MAIL_FROM_ADDRESS=

    DB_CONNECTION=mysql
    DB_HOST=
    DB_PORT=
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=
   # or use smtp details
   ```

4. Serve:
   ```bash
   php artisan serve
   ```
5. Finally visit:
   ```bash
   http://127.0.0.1:8000/login
   ```

## Notes

- Email verification uses Laravel's built-in flow. For Admin verification routes, we provide namespaced routes under `/admin/email/verify...`.
- CSV export uses streamed responses and does not load all rows into memory.
- Simple blade templates are included; style as needed.
- Validation rules cover required/optional and uniqueness. Password is required on create, optional on edit.
- Login uses `login_id` + password; email must be verified to proceed.

## URLs

### Admin
- Register: `/admin/register`
- Login: `/admin/login`
- Admin list: `/admin/member`
- Admin create: `/admin/member/new`
- Admin edit: `/admin/member/{id}/edit`
- Admin CSV: `/admin/member/export/csv`
- Member list: `/admin/customer`
- Member create: `/admin/customer/new`
- Member edit: `/admin/customer/{id}/edit`
- Member CSV: `/admin/customer/export/csv`

### Front (Member)
- Login: `/login`
- Register: `/entry`
- Verify notice: `/email/verify`
- My Page edit: `/mypage/edit`

## Security

- Both Admin and Customer models implement `MustVerifyEmail`.
- Logins fail if `email_verified_at` is null.
- Admin area requires `auth:admin`.

## Customization
- Add fields to migrations and update the `$fillable` properties and form views accordingly.
- Replace simple layouts with your CSS framework of choice.


## Login Screen JP
![alt text](https://github.com/tahsinasuchi/test-app-email-verification-/blob/main/public/Screenshot%202025-08-27%20at%2019.20.00.png)

## Login screen EN
![alt text](https://github.com/tahsinasuchi/test-app-email-verification-/blob/main/public/Screenshot%202025-08-27%20at%2019.20.06.png)

## Admin List
![alt text](https://github.com/tahsinasuchi/test-app-email-verification-/blob/main/public/Screenshot%202025-08-27%20at%2019.20.20.png)

## Customer List
![alt text](https://github.com/tahsinasuchi/test-app-email-verification-/blob/main/public/Screenshot%202025-08-27%20at%2019.36.33.png)