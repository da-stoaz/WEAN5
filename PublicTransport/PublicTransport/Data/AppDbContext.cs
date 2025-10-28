using Microsoft.EntityFrameworkCore;
using PublicTransport.Entities;

namespace PublicTransport.Data;

public class AppDbContext : DbContext
{
    public AppDbContext(DbContextOptions<AppDbContext> options) : base(options)
    {
    }

    protected override void OnModelCreating(ModelBuilder modelBuilder)
    {
        modelBuilder.Entity<PublicTransportE>()
            .HasMany(pt => pt.ServicePlans)
            .WithOne()
            .HasForeignKey(sp => sp.PublicTransportId);
    }

    public DbSet<PublicTransportE> PublicTransports { get; set; }
    public DbSet<ServicePlan> ServicePlans { get; set; }
}