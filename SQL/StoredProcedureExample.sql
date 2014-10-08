CREATE PROCEDURE wsmay1lab52
	@fname varchar(25),
	@lname varchar(25),
	@line1 varchar(50),
	@line2 varchar(50),
	@line3 varchar(50),
	@city varchar(30),
	@zip char(8)
AS
	IF EXISTS (SELECT * FROM Customers c WHERE c.FirstName = @fname AND c.LastName = @lname)
		BEGIN
		UPDATE Customers
		SET addressLine1 = @line1, addressLine2 = @line2, city = @city, zipCode = @zip
		WHERE FirstName = @fname AND LastName = @lname
		RETURN @@ROWCOUNT
		END
	ELSE
		INSERT INTO Customers(FirstName, LastName, addressLine1, addressLine2, city, zipCode)
		VALUES (@fname, @lname, @line1, @line2, @city, @zip)
		RETURN @@ROWCOUNT