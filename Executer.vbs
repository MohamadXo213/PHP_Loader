Set WshShell = CreateObject("WScript.Shell")
command = WScript.Arguments.Item(0)
For i = 1 To WScript.Arguments.Count -1
	command = command + " " + WScript.Arguments.Item(i)
Next
WshShell.Run command,0,False
