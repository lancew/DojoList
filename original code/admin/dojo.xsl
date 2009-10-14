<?xml version="1.0" encoding="ISO-8859-1"?>

<xsl:stylesheet version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

<xsl:template match="/">
  <html>
  <body>
  <h2>Hampshire Judo Clubs</h2>
  <table border="1">
    <tr bgcolor="#9acd32">
      <th>Club Name</th>
      <th>Address</th>
    </tr>
    <xsl:for-each select="Dojo">
    <tr>
      <td><xsl:value-of select="ClubName"/></td>
      <td><xsl:value-of select="DojoAddress"/></td>
    </tr>
    </xsl:for-each>
  </table>
  </body>
  </html>
</xsl:template>

</xsl:stylesheet>