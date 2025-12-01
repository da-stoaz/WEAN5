using Microsoft.EntityFrameworkCore;

namespace DeviceApiForMobile.Data;

public class DeviceDbContext(DbContextOptions<DeviceDbContext> options) : DbContext(options)
{
    
    public DbSet<DeviceInfo> DeviceInfos { get; set; }
}