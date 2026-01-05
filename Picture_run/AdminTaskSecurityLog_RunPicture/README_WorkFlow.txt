1. Register will only register as User
2. Login with check permission. If permission is admin-> admin dashboard
3. All register, login, logout all have flag-> save into database as securitylogs.
4. Admin can give task to user but user can only give task to user.
5. Logout only use invalidate ( stop session)
6. API use Models->Repository->Service->Controller to handle bug easy and make a clean code.